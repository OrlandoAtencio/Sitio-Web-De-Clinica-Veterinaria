<?php
session_start();
require_once "conexion.php";

// Verificar que llegue por POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.php");
    exit;
}

// Recibir datos del formulario
$correo = trim($_POST['correo']);
$password = trim($_POST['password']);

// Validación básica
if (empty($correo) || empty($password)) {
    header("Location: ../login.php?error=1");
    exit;
}

// Preparar consulta SQL
$stmt = $conn->prepare("SELECT id, nombre, correo, password_hash, rol FROM users WHERE correo = ? LIMIT 1");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

// Validar existencia del usuario
if ($result->num_rows === 0) {
    header("Location: ../login.php?error=1");
    exit;
}

$user = $result->fetch_assoc();

// Verificar contraseña hasheada
if (!password_verify($password, $user['password_hash'])) {
    header("Location: ../login.php?error=1");
    exit;
}

// Si llega aquí: LOGIN EXITOSO
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['nombre'];
$_SESSION['user_role'] = $user['rol'];
$_SESSION['user_email'] = $user['correo'];

// Redirigir al dashboard
header("Location: ../dashboard.php");
exit;
