<?php
session_start();

// Proteger página
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Conexión a BD
$mysqli = new mysqli("localhost", "root", "", "clinica_vet");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = $_POST['nombre'];
    $especie = $_POST['especie'];
    $raza = $_POST['raza'];
    $edad = $_POST['edad'];
    $dueno = $_POST['dueno'];
    $telefono = $_POST['telefono'];

    // Query
    $sql = "INSERT INTO pacientes (nombre, especie, raza, edad, dueño, telefono)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssiss", $nombre, $especie, $raza, $edad, $dueno, $telefono);

        if ($stmt->execute()) {
            $mensaje = "Paciente registrado exitosamente.";
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
    <title>Registrar Paciente</title>
    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>

<h1>Registrar Paciente</h1>

<?php if ($mensaje !== ""): ?>
    <p style="color: green; font-weight: bold;">
        <?php echo $mensaje; ?>
    </p>
<?php endif; ?>

<form method="POST">

    <label>Nombre del paciente:</label>
    <input type="text" name="nombre" required>

    <label>Especie:</label>
    <input type="text" name="especie" required>

    <label>Raza:</label>
    <input type="text" name="raza">

    <label>Edad:</label>
    <input type="number" name="edad" min="0">

    <label>Nombre del dueño:</label>
    <input type="text" name="dueno" required>

    <label>Teléfono del dueño:</label>
    <input type="text" name="telefono">

    <br><br>
    <button type="submit">Registrar Paciente</button>
</form>

<br>
<a href="dashboard.php">← Volver al dashboard</a>

</body>
</html>
