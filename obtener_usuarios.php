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

$sql = "SELECT id, app, nombre, username, email, password, rol FROM usuarios";
$result = $conn->query($sql);

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode(["data" => $usuarios]); // Formato compatible con DataTables
$conn->close();
?>
