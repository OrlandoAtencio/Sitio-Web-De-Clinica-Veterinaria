<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    exit("Acceso no autorizado");
}

$mysqli = new mysqli("localhost", "root", "", "clinica_vet");

// Primero eliminamos las consultas de esos pacientes
$deleteConsultas = "
DELETE c FROM consultas c
WHERE c.paciente_id IN (
    SELECT id FROM pacientes
    WHERE (
        SELECT TIMESTAMPDIFF(MONTH, MAX(fecha), CURDATE())
        FROM consultas
        WHERE paciente_id = pacientes.id
    ) >= 24
    OR (
        SELECT COUNT(*) FROM consultas WHERE paciente_id = pacientes.id
    ) = 0
)
";

$mysqli->query($deleteConsultas);

// Luego eliminamos los pacientes
$deletePacientes = "
DELETE FROM pacientes
WHERE id NOT IN (SELECT paciente_id FROM consultas)
";

$mysqli->query($deletePacientes);

$mysqli->close();

header("Location: ../system-maintenance.php");
exit;
