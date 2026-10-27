<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $clave   = $_POST['clave'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        if ($clave === $fila['clave']) {
            $_SESSION['usuario_id'] = $fila['id'];
            $_SESSION['usuario']    = $fila['usuario'];
            echo "Bienvenido, " . htmlspecialchars($fila['usuario']) . ". Acceso concedido.";
        } else {
            echo "Usuario o clave incorrectos.";
        }
    } else {
        echo "Usuario o clave incorrectos.";
    }
    $stmt->close();
}
?>
<form method="POST">
  Usuario: <input type="text" name="usuario"><br>
  Clave: <input type="password" name="clave"><br>
  <button type="submit">Ingresar</button>
</form>
