<?php
require_once "conexion.php";

if ($conexion) {
    echo "Conexión OK. Versión MySQL: " . $conexion->server_info;
} else {
    echo "Fallo la conexión.";
}
?>
