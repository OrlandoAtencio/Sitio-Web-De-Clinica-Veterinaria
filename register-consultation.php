<?php
session_start();

// PROTEGER LA PÁGINA
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Conexión a BD
$mysqli = new mysqli("localhost", "root", "", "clinica_vet");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $paciente_id = $_POST['paciente_id'];
    $fecha = $_POST['fecha'];
    $motivo = $_POST['motivo'];
    $diagnostico = $_POST['diagnostico'];
    $tratamiento = $_POST['tratamiento'];

    $sql = "INSERT INTO consultas (paciente_id, fecha, motivo, diagnostico, tratamiento)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("issss", $paciente_id, $fecha, $motivo, $diagnostico, $tratamiento);

        if ($stmt->execute()) {
            $mensaje = "Consulta registrada exitosamente.";
        } else {
            $mensaje = "Error al guardar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $mensaje = "Error en prepare(): " . $mysqli->error;
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Consulta</title>

    <!-- Ajustado porque ahora estamos en la raíz -->
    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>

<h1>Registrar Consulta</h1>

<?php if ($mensaje !== ""): ?>
    <p style="color: green; font-weight: bold;">
        <?php echo $mensaje; ?>
    </p>
<?php endif; ?>

<form method="POST">

    <label>ID del paciente:</label>
    <input type="number" name="paciente_id" required>

    <label>Fecha de la consulta:</label>
    <input type="date" name="fecha" required>

    <label>Motivo:</label>
    <input type="text" name="motivo" required>

    <label>Diagnóstico:</label>
    <textarea name="diagnostico"></textarea>

    <label>Tratamiento:</label>
    <textarea name="tratamiento"></textarea>

    <br><br>
    <button type="submit">Registrar consulta</button>
</form>

<br>
<a href="dashboard.php">← Volver al dashboard</a>

</body>
</html>
