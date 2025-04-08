<?php
if (isset($_POST['nueva_contraseña']) && isset($_POST['token'])) {
    $nueva_contraseña = $_POST['nueva_contraseña'];
    $token = $_POST['token'];

    // Encriptar la nueva contraseña
    $nueva_contraseña_encriptada = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

    // Conectar a la base de datos
    $db = new DB();
    $conn = $db->connect();

    // Actualizar la contraseña y eliminar el token
    $stmt = $conn->prepare("UPDATE usuarios SET password = :password, token = NULL WHERE token = :token");
    $stmt->bindParam(':password', $nueva_contraseña_encriptada);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    echo "Contraseña cambiada exitosamente.";
}
?>
