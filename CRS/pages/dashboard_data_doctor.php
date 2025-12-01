<?php
session_start();
include "../conexion.php";

// Solo un doctor puede ver esto
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== "doctor") {
    echo json_encode(["error" => "No autorizado"]);
    exit();
}

$id_doctor = $_SESSION['usuario_id'];

// Total de consultas hechas por ese doctor
$sql1 = "SELECT COUNT(*) AS total FROM consultas WHERE id_doctor = $id_doctor";
$r1 = $conexion->query($sql1)->fetch_assoc();

// Pacientes distintos atendidos por el doctor
$sql2 = "SELECT COUNT(DISTINCT id_paciente) AS total FROM consultas WHERE id_doctor = $id_doctor";
$r2 = $conexion->query($sql2)->fetch_assoc();

// Suma total del costo de las consultas del doctor
$sql3 = "SELECT IFNULL(SUM(costo), 0) AS total FROM consultas WHERE id_doctor = $id_doctor";
$r3 = $conexion->query($sql3)->fetch_assoc();

echo json_encode([
    "consultas" => $r1["total"],
    "pacientes_atendidos" => $r2["total"],
    "ingresos" => $r3["total"]
]);
?>

