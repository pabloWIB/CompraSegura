Este es el proyecto compra segura que usamos en la materia seguridad de aplicaciones

Tecnología en Desarrollo de Software para Negocios Digitales, Universidad de Manizales
Pablo Nieto Pérez

Es una tiendita en php y MySQL que está hecha insegura a propósito para practicar, la corro en mi xampp local en http://localhost/compraseguras/ y la base se crea con el archivo compraseguras.sql. Tiene el login, el registro, el buscador de productos y los pedidos

Cuando la revisé al principio encontré que casi todas las consultas pegaban lo que escribía el usuario directo en el sql, entonces el login se podía saltar con ' OR ''=' y el buscador dejaba sacar los usuarios con sus claves. El pedido además tomaba el precio de un campo oculto del formulario y uno lo podía cambiar a 1 desde el navegador, la app se conectaba como root, las claves se guardaban en texto plano, el nombre se imprimía sin escapar y pedido.php dejaba hacer pedidos sin iniciar sesión

En el Producto 2 corregí la inyección sql en los cinco archivos con consultas preparadas, una lista blanca en el registro y un usuario de base de datos con los permisos justos (negocioseguro_app), y el precio ahora se vuelve a consultar en la base. Lo que falta es guardar las claves con password_hash, eso va en otra entrega

En la carpeta tareas están las entregas: la Tarea 1, las imágenes de la Tarea 4 y el informe del Producto 2 con sus capturas

La versión en línea está en https://negocioseguro.wib.digital y corre en nuestro VPS con Docker (Caddy, php con Apache y MariaDB), los archivos para montarla están en la carpeta deploy. Para actualizarla se entra al VPS, en la carpeta del proyecto se hace git pull y después dentro de deploy se corre docker compose -p compraseguras up -d --build
