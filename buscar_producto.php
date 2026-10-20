<?php
session_start();
$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($busqueda !== '') {
    try {
        // Capa 3 con PDO. Se conecta con el usuario restringido de la Capa 1
        // (no con root) y se activan las excepciones para manejarlas nosotros.
        $pdo = new PDO(
            "mysql:host=localhost;dbname=compraseguras;charset=utf8mb4",
            "negocioseguro_app",
            "ClaveSegura123!"
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Marcador de posicion con nombre. El % se agrega en el valor, no en el SQL.
        $stmt = $pdo->prepare("SELECT nombre, precio FROM productos WHERE nombre LIKE :busqueda");
        $stmt->bindValue(':busqueda', '%' . $busqueda . '%');
        $stmt->execute();

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo htmlspecialchars($fila['nombre']) . " - $" . htmlspecialchars($fila['precio']) . "<br>";
        }
    } catch (PDOException $e) {
        // Nunca mostrar $e->getMessage() al usuario: eso reabriria la inyeccion
        // basada en errores de la Clase 6.
        echo "Ocurrio un error al procesar la busqueda. Intente nuevamente.";
    }
}
?>
<form method="GET">
  Buscar producto: <input type="text" name="q">
  <button type="submit">Buscar</button>
</form>
