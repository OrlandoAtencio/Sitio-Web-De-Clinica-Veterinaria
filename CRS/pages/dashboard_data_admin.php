<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Conexión a la BD
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica_vet";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Error en la conexión: " . $conn->connect_error]));
}

// 1. Total de pacientes
$sql_pacientes = "SELECT COUNT(*) AS total FROM pacientes";
$result_pacientes = $conn->query($sql_pacientes);
$total_pacientes = $result_pacientes->fetch_assoc()['total'];

// 2. Total de consultas
$sql_consultas = "SELECT COUNT(*) AS total FROM consultas";
$result_consultas = $conn->query($sql_consultas);
$total_consultas = $result_consultas->fetch_assoc()['total'];

// 3. Total de médicos (usuarios con rol 'medico')
$sql_medicos = "SELECT COUNT(*) AS total FROM usuarios WHERE rol = 'medico'";
$result_medicos = $conn->query($sql_medicos);
$total_medicos = $result_medicos->fetch_assoc()['total'];

// Devolver JSON
echo json_encode([
    "pacientes" => $total_pacientes,
    "consultas" => $total_consultas,
    "medicos" => $total_medicos
]);

$conn->close();
?>
