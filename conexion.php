<?php
$host = 'localhost'; // o tu servidor de base de datos
$dbname = 'techzone';
$username = 'root';
$password = '';

try {
    // Conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Establecer el modo de error a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error al conectar a la base de datos: ' . $e->getMessage();
    exit;
}
?>
