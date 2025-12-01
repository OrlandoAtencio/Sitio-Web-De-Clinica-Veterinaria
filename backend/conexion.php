<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "clinica_vet";

$conn = new mysqli($server, $user, $password, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
