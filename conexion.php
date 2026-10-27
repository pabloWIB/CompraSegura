<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$user = "negocioseguro_app";
$pass = "ClaveSegura123!";
$db   = "compraseguras";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error critico de conexion a la base de datos.");
}
?>
