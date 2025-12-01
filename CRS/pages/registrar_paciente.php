<?php

// 1. Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "clinica_vet");

// Verificar conexión
if ($conexion->connect_errno) {
    die("Error al conectar: " . $conexion->connect_error);
}

// 2. Recibir datos del formulario
$nombre = $_POST['nombre'] ?? '';
$especie = $_POST['especie'] ?? '';
$edad = $_POST['edad'] ?? '';

// 3. Validar (muy básico por ahora)
if ($nombre == "" || $especie == "" || $edad == "") {
    die("Error: Todos los campos son obligatorios");
}

// 4. Insertar en la base de datos
$sql = "INSERT INTO pacientes (nombre, especie, edad) VALUES ('$nombre', '$especie', '$edad')";

if ($conexion->query($sql)) {
    echo "Paciente registrado correctamente.";
    echo "<br><a href='registrar_paciente.html'>Registrar otro paciente</a>";
} else {
    echo "Error al registrar: " . $conexion->error;
}

$conexion->close();
?>
