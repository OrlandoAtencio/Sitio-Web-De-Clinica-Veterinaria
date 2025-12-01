<?php
session_start();

// PROTEGER PÁGINA
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Conexión a BD
$mysqli = new mysqli("localhost", "root", "", "clinica_vet");

// Total de pacientes
$totalPacientes = 0;
$result = $mysqli->query("SELECT COUNT(*) AS total FROM pacientes");
if ($result) {
    $row = $result->fetch_assoc();
    $totalPacientes = $row['total'];
}

// Pacientes inactivos = Sin consultas en 24+ meses
$inactivos = 0;
$listaInactivos = [];

// Consulta para obtener inactivos
$sql = "
    SELECT p.*, 
           MAX(c.fecha) AS ultima_consulta,
           TIMESTAMPDIFF(MONTH, MAX(c.fecha), CURDATE()) AS meses_sin_consulta
    FROM pacientes p
    LEFT JOIN consultas c ON p.id = c.paciente_id
    GROUP BY p.id
    HAVING meses_sin_consulta >= 24 OR ultima_consulta IS NULL
";

$result2 = $mysqli->query($sql);

if ($result2) {
    while ($row = $result2->fetch_assoc()) {
        $listaInactivos[] = $row;
    }
    $inactivos = count($listaInactivos);
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mantenimiento del Sistema</title>

    <!-- Ajusta la ruta del CSS EXACTAMENTE como estaba -->
    <link rel="stylesheet" href="src/css/system-maintenance.css">
</head>

<body class="page-background">

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <a href="dashboard.php" class="back-btn">←</a>

        <div>
            <h2 class="title">Mantenimiento del Sistema</h2>
            <p class="subtitle">Gestión de pacientes inactivos</p>
        </div>
    </div>

    <!-- WARNING -->
    <div class="warning-box">
        <span class="warning-icon">⚠</span>
        <p><strong>Advertencia:</strong> La eliminación definitiva no puede deshacerse.  
        Se recomienda archivar pacientes antes de eliminarlos permanentemente.</p>
    </div>

    <!-- STATS -->
    <div class="stats-grid">

        <div class="stat-card teal">
            <p class="stat-label">Total de Pacientes</p>
            <p class="stat-value"><?php echo $totalPacientes; ?></p>
        </div>

        <div class="stat-card amber">
            <p class="stat-label">Pacientes Inactivos</p>
            <p class="stat-value"><?php echo $inactivos; ?></p>
            <p class="stat-hint">Sin consultas en 24+ meses</p>
        </div>

        <div class="stat-card blue">
            <p class="stat-label">Seleccionados</p>
            <p class="stat-value">0</p>
        </div>

    </div>

    <!-- ACTIONS -->
    <div class="actions-box">
        <div class="actions-header">
            <h3 class="actions-title">Acciones Rápidas</h3>

            <div class="actions-buttons">
                <button class="btn-select">Seleccionar todos</button>
                <button class="btn-deselect">Deseleccionar todos</button>
            </div>
        </div>

        <div class="actions-main">
            <a href="backend/maintenance/archive_inactive.php" class="btn-archive">
                Archivar Automáticamente (<?php echo $inactivos; ?>)
            </a>

            <a href="backend/maintenance/delete_inactive.php" class="btn-delete"
            onclick="return confirm('¿Seguro que deseas eliminar DEFINITIVAMENTE a todos los pacientes inactivos? Esta acción NO se puede deshacer.');">
            Eliminar Definitivamente (<?php echo $inactivos; ?>)
        </a>

        </div>
    </div>

    <!-- LISTA DE PACIENTES INACTIVOS -->
    <div class="list-box">

        <div class="list-header">
            <h3 class="actions-title">Pacientes Inactivos (24+ meses sin consultas)</h3>
            <p class="subtitle"><?php echo $inactivos; ?> pacientes encontrados</p>
        </div>

        <?php if ($inactivos == 0): ?>
            <div class="list-empty">
                <div class="empty-icon">✔</div>
                <p class="empty-title">¡Sistema limpio!</p>
                <p class="empty-text">No hay pacientes inactivos en este momento</p>
            </div>

        <?php else: ?>

            <?php foreach ($listaInactivos as $p): ?>
                <div class="patient-item">

                    <input type="checkbox" class="patient-checkbox" />

                    <div class="patient-data">
                        <p class="patient-name"><?php echo $p['nombre']; ?></p>
                        <p class="patient-info">
                            <?php echo $p['especie'] . " - " . $p['raza'] . " (" . $p['edad'] . " años)"; ?>
                        </p>
                        <p class="patient-info">Dueño: <?php echo $p['dueño']; ?></p>
                    </div>

                    <div class="patient-consult">
                        <p class="consult-label">Última consulta:</p>
                        <p class="consult-date">
                            <?php echo $p['ultima_consulta'] ? $p['ultima_consulta'] : "Nunca"; ?>
                        </p>

                        <p class="consult-months">
                            <?php 
                            echo $p['ultima_consulta'] 
                                ? "Hace " . $p['meses_sin_consulta'] . " meses"
                                : "Nunca atendido";
                            ?>
                        </p>
                    </div>

                </div>
            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</div>

</body>
</html>
