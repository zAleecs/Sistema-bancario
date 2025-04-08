<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root"; // Cambia si es necesario
$password = ""; // Agrega tu contraseña si la tienes
$database = "techzone"; // Cambia al nombre real de tu base de datos

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(["error" => "Conexión fallida: " . $conn->connect_error]);
    exit;
}

$sql = "SELECT id, app, apm, nombre, tel, rfc, curp, sueldo, historial FROM clientes";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => "Error en la consulta: " . $conn->error]);
    exit;
}

$clientes = [];
while ($row = $result->fetch_assoc()) {
    $clientes[] = $row;
}

if (empty($clientes)) {
    echo json_encode(["error" => "No se encontraron registros"]);
} else {
    echo json_encode(["data" => $clientes]);
}

$conn->close();
?>
