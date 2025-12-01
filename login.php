<?php
session_start();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Capturar errores enviados desde backend/login.php
$error = "";
if (isset($_GET['error'])) {
    if ($_GET['error'] === "1") {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login | Oregón VetCare</title>

    <!-- Hoja de estilos -->
    <link rel="stylesheet" href="src/css/llogin.css">

    <!-- Íconos Lucide -->
    <link rel="stylesheet" href="https://unpkg.com/lucide-static/font/lucide.css" />
</head>

<body class="login-background">

    <div class="container">

        <!-- Logo -->
        <div class="header">
            <div class="login-logo">
                <img src="src/icons/1logo-vetcare.svg" alt="Logo VetCare" class="logo-img">
            </div>

            <h1 class="title">Clínica Veterinaria</h1>
            <h2 class="subtitle">Oregón VetCare</h2>
            <p class="description">Sistema de Gestión Médica</p>
        </div>

        <!-- Tarjeta de Login -->
        <div class="login-card">
            <h3 class="card-title">Iniciar Sesión</h3>

            <!-- Mostrar error si existe -->
            <?php if ($error): ?>
                <div class="error-box" style="color: red; margin-bottom: 10px;">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="backend/login.php" method="POST">

                <!-- Email -->
                <label for="email">Correo electrónico</label>
                <input
                    type="email"
                    name="correo"
                    id="email"
                    placeholder="usuario@vetcare.com"
                    class="login-input"
                    required
                />

                <!-- Password -->
                <label for="password">Contraseña</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="••••••••"
                    class="login-input"
                    required
                />

                <!-- Botón -->
                <button type="submit" class="login-btn">
                    Ingresar al Sistema
                </button>
            </form>
        </div>

        <p c
