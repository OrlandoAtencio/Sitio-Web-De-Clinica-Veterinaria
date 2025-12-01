<?php
session_start();
require '../config/db.php'; // Ajusta la ruta si es necesario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    // Buscar usuario por correo
    $stmt = $conn->prepare("SELECT id, nombre, correo, password_hash, rol FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {

        $usuario = $resultado->fetch_assoc();

        // Comparar contraseña
        if ($password === $usuario['password_hash']) {

            // Guardar datos en sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol'];

            // Redirigir según el rol
            if ($usuario['rol'] === 'admin') {
                header("Location: ../pages/admin-dashboard.html");
            } else if ($usuario['rol'] === 'doctor') {
                header("Location: ../pages/doctor-dashboard.html");
            }
            exit;
        } else {
            echo "❌ Contraseña incorrecta";
        }

    } else {
        echo "❌ Usuario no encontrado";
    }
}
?>

