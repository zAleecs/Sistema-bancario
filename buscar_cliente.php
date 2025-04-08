<?php
require 'conexion.php'; // Asegúrate de que este archivo tiene la conexión a MySQL

if (isset($_POST['rfc'])) {
    $rfc = $_POST['rfc'];
    
    $query = "SELECT nombre FROM clientes WHERE rfc = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $rfc);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(["success" => true, "nombre" => $row['nombre']]);
    } else {
        echo json_encode(["success" => false]);
    }
    
    $stmt->close();
    $conn->close();
}
?>
