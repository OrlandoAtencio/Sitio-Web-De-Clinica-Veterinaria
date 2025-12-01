<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    exit("Acceso no autorizado");
}

$mysqli = new mysqli("localhost", "root", "", "clinica_vet");

// Archivar todos los pacientes sin consultas o con última consulta hace 24+ meses
$sql = "
UPDATE pacientes p
LEFT JOIN (
    SELECT paciente_id, MAX(fecha) AS ultima_fecha
    FROM consultas
    GROUP BY paciente_id
) AS c ON p.id = c.paciente_id
SET p.archivado = 1
WHERE p.archivado = 0
AND (
    c.ultima_fecha IS NULL
    OR TIMESTAMPDIFF(MONTH, c.ultima_fecha, CURDATE()) >= 24
)
";

$mysqli->query($sql);

$mysqli->close();

// Regresar al mantenimiento
header("Location: ../system-maintenance.php");
exit;
