<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// ← Necesito saber el nombre EXACTO de tu tabla y columnas
// Cuando me lo digas, reemplazo esto correctamente.

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Por ahora dejo estos nombres de ejemplo
    // Luego los ajustamos a los reales
    $nombre_dueno = $_POST['nombre_dueno'] ?? null;
    $nombre_mascota = $_POST['nombre_mascota'] ?? null;
    $tipo_mascota = $_POST['tipo_mascota'] ?? null;
    $edad = $_POST['edad'] ?? null;

    // Validación rápida
    if (!$nombre_dueno || !$nombre_mascota || !$tipo_mascota) {
        header("Location: ../src/pages/register-patient.php?msg=error_campos");
        exit;
    }

    // Ejemplo de INSERT (luego ajustamos tu tabla real)
    $sql = "INSERT INTO pacientes (nombre_mascota, nombre_dueno, tipo_mascota, edad)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre_mascota, $nombre_dueno, $tipo_mascota, $edad);

    if ($stmt->execute()) {
        header("Location: ../src/pages/register-patient.php?msg=ok");
    } else {
        header("Location: ../src/pages/register-patient.php?msg=error_sql");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../src/pages/register-patient.php");
    exit;
}
