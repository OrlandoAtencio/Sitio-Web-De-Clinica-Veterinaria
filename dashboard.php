<?php
session_start();

// Si NO hay sesión → regresar al login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$nombre = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal - Clínica Vet</title>
    <link rel="stylesheet" href="src/css/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #f4f4f4;
        }
        h1 {
            margin-bottom: 20px;
        }
        .menu {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 400px;
        }
        .menu a {
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            text-decoration: none;
            font-size: 18px;
            color: #333;
            text-align: center;
            transition: 0.2s ease;
        }
        .menu a:hover {
            background: #d8f3dc;
        }
        .logout {
            background: #ffdddd !important;
        }
        .logout:hover {
            background: #ffb3b3 !important;
        }
    </style>
</head>
<body>

<h1>Bienvenido, <?php echo htmlspecialchars($nombre); ?> 👋</h1>
<p>Selecciona una acción:</p>

<div class="menu">

    <a href="register-patient.php">➕ Registrar Paciente</a>

    <a href="register-consultation.php">📝 Registrar Consulta</a>

    <!-- (Opcional) Pantalla futura -->
    <a href="#" style="opacity:0.5; cursor:not-allowed;">📋 Lista de Pacientes (próximamente)</a>

    <!-- (Opcional) Pantalla futura -->
    <a href="#" style="opacity:0.5; cursor:not-a
