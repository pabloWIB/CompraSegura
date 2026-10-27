<?php
include 'conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $clave   = $_POST['clave'];

    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $usuario)) {
        die("Nombre de usuario invalido. Use solo letras, numeros y guion bajo (3 a 20 caracteres).");
    }

    if (strlen($clave) < 8) {
        die("La clave debe tener al menos 8 caracteres.");
    }

    $stmt = $conn->prepare("INSERT INTO usuarios (usuario, clave) VALUES (?, ?)");
    $stmt->bind_param("ss", $usuario, $clave);

    if ($stmt->execute()) {
        echo "Usuario registrado con exito.";
    } else {
        echo "No se pudo registrar el usuario.";
    }
    $stmt->close();
}
?>
<form method="POST">
  Nuevo usuario: <input type="text" name="usuario"><br>
  Clave: <input type="password" name="clave"><br>
  <button type="submit">Registrarme</button>
</form>
