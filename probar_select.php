<?php
include "conexion.php";

$sql = "SELECT * FROM pacientes LIMIT 10";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    echo "<h3>Pacientes encontrados:</h3>";
    while($fila = $resultado->fetch_assoc()) {
        echo "ID: " . $fila["id"] . 
             " - Nombre: " . $fila["nombre"] . 
             " - Especie: " . $fila["especie"] . "<br>";
    }
} else {
    echo "No hay pacientes registrados.";
}

$conexion->close();
?>
