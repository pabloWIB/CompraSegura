<?php
session_start();
$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($busqueda !== '') {
    try {
        $pdo = new PDO(
            "mysql:host=localhost;dbname=compraseguras;charset=utf8mb4",
            "negocioseguro_app",
            "ClaveSegura123!"
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT nombre, precio FROM productos WHERE nombre LIKE :busqueda");
        $stmt->bindValue(':busqueda', '%' . $busqueda . '%');
        $stmt->execute();

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo htmlspecialchars($fila['nombre']) . " - $" . htmlspecialchars($fila['precio']) . "<br>";
        }
    } catch (PDOException $e) {
        echo "Ocurrio un error al procesar la busqueda. Intente nuevamente.";
    }
}
?>
<form method="GET">
  Buscar producto: <input type="text" name="q">
  <button type="submit">Buscar</button>
</form>
