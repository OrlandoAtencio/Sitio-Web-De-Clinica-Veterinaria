<?php
session_start();
require_once "conexion.php";

// Verifica que solo se acceda mediante POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validar campos obligatorios
    if (
        empty($_POST['nombre_dueno']) ||
        empty($_POST['nombre_mascota']) ||
        empty($_POST['tipo_mascota']) ||
        empty($_POST['motivo']) ||
        empty($_POST['fecha'])
    ) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Sanitizar y recibir datos
    $nombre_dueno   = trim($_POST['nombre_dueno']);
    $nombre_mascota = trim($_POST['nombre_mascota']);
    $tipo_mascota   = trim($_POST['tipo_mascota']);
    $motivo         = trim($_POST['motivo']);
    $fecha          = trim($_POST['fecha']);

    // Insertar consulta
    $sql = "INSERT INTO consultas (nombre_dueno, nombre_mascota, tipo_mascota, motivo, fecha_consulta)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error en prepare(): " . $conn->error);
    }

    $stmt->bind_param("sssss", $nombre_dueno, $nombre_mascota, $tipo_mascota, $motivo, $fecha);

    if ($stmt->execute()) {
        // Redirige con mensaje
        header("Location: ../pages/register-consultation.php?msg=ok");
        exit;
    } else {
        die("Error al guardar la consulta: " . $stmt->error);
    }

} else {
    // Si alguien intenta entrar por GET
    echo "Acceso no válido.";
}
?>
