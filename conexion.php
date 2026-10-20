<?php
// Capa 1 - Minimo privilegio: la app ya no se conecta como root.
// Se usa el usuario 'negocioseguro_app', que solo tiene SELECT, INSERT y UPDATE
// sobre la base compraseguras (no puede DROP, ALTER ni DELETE).
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$user = "negocioseguro_app";
$pass = "ClaveSegura123!";
$db   = "compraseguras";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    // No se muestra el detalle tecnico al usuario (eso seria A05/A09).
    die("Error critico de conexion a la base de datos.");
}
?>
