# Análisis de hallazgos | compraseguras

Revisión rápida de los archivos PHP y la base de datos. Enfoque en seguridad
básica, no exhaustivo.

---

## Resumen

| # | Archivo | Problema | Gravedad |
|---|---------|----------|----------|
| 1 | login.php | Inyección SQL en el login | Alta |
| 2 | registro.php | Inyección SQL en el INSERT | Alta |
| 3 | buscar_producto.php | Inyección SQL en la búsqueda | Alta |
| 4 | pedido.php | Inyección SQL + precio enviado por el cliente | Alta |
| 5 | usuarios (tabla) | Claves guardadas en texto plano | Alta |
| 6 | login/registro | Sin escape de salida (riesgo XSS) | Media |
| 7 | conexion.php | Usuario root de la BD para la app | Media |
| 8 | pedido.php | No valida que haya sesión iniciada | Media |
| 9 | General | Sin control CSRF ni validación de datos | Baja |

---

## Detalle

### 1. Inyección SQL en el login (login.php)
La consulta concatena directamente lo que escribe el usuario:
```php
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave'";
```
Escribiendo `' OR ''='` en usuario y clave se salta el login sin conocer
ninguna contraseña. **Probado: entra como admin.**
→ Solución: usar consultas preparadas (`prepare` + `bind_param`).

### 2. Inyección SQL en el registro (registro.php)
Mismo patrón en el INSERT:
```php
$sql = "INSERT INTO usuarios (usuario, clave) VALUES ('$usuario', '$clave')";
```
Un valor con comillas puede romper o alterar la consulta.
→ Solución: consulta preparada.

### 3. Inyección SQL en la búsqueda (buscar_producto.php)
```php
$sql = "SELECT * FROM productos WHERE nombre LIKE '%$busqueda%'";
```
El parámetro `q` de la URL entra directo al SQL.
→ Solución: consulta preparada con el `%...%` en el bind, no en la cadena.

### 4. Precio confiado al cliente (pedido.php)
El precio viene de un campo oculto del formulario:
```php
<input type="hidden" name="precio" value="3000">
```
El usuario puede cambiarlo (por ejemplo a 1) y pagar lo que quiera. Además el
INSERT también concatena valores → inyección SQL.
→ Solución: leer el precio desde la tabla `productos` por su `id` en el
servidor, nunca desde el formulario. Consulta preparada.

### 5. Claves en texto plano (tabla usuarios)
Las contraseñas se guardan tal cual (`admin123`, `miclave2024`). Cualquiera con
acceso a la BD las ve.
→ Solución: guardar con `password_hash()` y verificar con `password_verify()`.

### 6. Salida sin escapar (posible XSS)
Se imprime el nombre de usuario directo:
```php
echo "Bienvenido, " . $fila['usuario'];
```
Si un usuario se registra con un nombre que contenga HTML/JS, se ejecuta al
mostrarlo.
→ Solución: `htmlspecialchars()` al imprimir datos del usuario.

### 7. Uso de root para la aplicación (conexion.php)
La app se conecta como `root`, que puede hacer todo en el servidor MySQL.
→ Solución: crear un usuario dedicado con permisos solo sobre la base
`compraseguras`.

### 8. pedido.php no exige sesión
Usa `$_SESSION['usuario_id'] ?? 0`, así que registra pedidos con usuario 0
aunque nadie haya iniciado sesión.
→ Solución: si no hay sesión, redirigir a login.php.

### 9. Sin CSRF ni validación
Los formularios no tienen token anti-CSRF ni validan tipos/longitudes de los
datos recibidos.
→ Solución (más adelante): token CSRF y validar entradas.

---

## Nota
Casi todo se resume en dos cosas: **usar consultas preparadas** en vez de
concatenar, y **hashear las contraseñas**. Eso solo ya cierra los hallazgos 1
a 5. El resto son mejoras de segundo nivel.
