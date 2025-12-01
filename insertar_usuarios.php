<?php
require "conexion.php";

// Activar errores
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function crearUsuario($nombre, $correo, $password, $rol) {
    global $conexion;

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, correo, password_hash, rol, creado_en)
            VALUES (?, ?, ?, ?, NOW())";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $correo, $password_hash, $rol);
    $stmt->execute();

    echo "Usuario creado: $correo<br>";
}

// Admin
crearUsuario("Administrador", "admin.oregon@vetcare.com", "Adm!nVet24*", "admin");

// Médicos
crearUsuario("Dra. Ana", "med.a@vetcare.com", "DrA-Vet#92", "doctor");
crearUsuario("Dr. Bernardo", "med.b@vetcare.com", "DrB-Vet#77", "doctor");
crearUsuario("Dr. Carlos", "med.c@vetcare.com", "DrC-Vet#51", "doctor");

echo "<br>Proceso finalizado.";
?>

