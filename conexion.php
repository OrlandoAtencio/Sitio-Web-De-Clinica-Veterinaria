<?php
// conexion.php
$host = "localhost";
$usuario = "root";
$clave = "";        // si tienes contraseña en MySQL, ponla aquí
$bd = "clinica_vet";

$conexion = new mysqli($host, $usuario, $clave, $bd);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
// Opcional: establecer charset
$conexion->set_charset("utf8mb4");
?>
