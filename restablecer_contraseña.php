<?php
// Incluir la clase de conexión a la base de datos
require_once 'includes/db.php';
session_start();

// Verificar si el token es válido
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Crear una nueva instancia de la clase DB
    $db = new DB();
    $conn = $db->connect();

    // Verificar si el token existe en la base de datos
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Token válido, mostrar formulario para cambiar la contraseña
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nueva_contraseña = $_POST['password'];

            // Encriptar la nueva contraseña con MD5
            $nueva_contraseña_encriptada = md5($nueva_contraseña);

            // Actualizar la contraseña en la base de datos
            $updateStmt = $conn->prepare("UPDATE usuarios SET password = :password, token = NULL WHERE token = :token");
            $updateStmt->bindParam(':password', $nueva_contraseña_encriptada);
            $updateStmt->bindParam(':token', $token);
            $updateStmt->execute();

            // Redirigir al usuario a la página de inicio de sesión o mostrar mensaje
            echo "Contraseña restablecida con éxito. Ahora puedes iniciar sesión con tu nueva contraseña.";
        } else {
            // Mostrar el formulario para cambiar la contraseña
            echo '
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>Restablecer Contraseña - TechZone</title>
                <link rel="stylesheet" href="main.css">
                <style>
                    body {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                        background-color: #f4f4f4;
                    }
                    form {
                        background-color: #eee;
                        width: 400px;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                        text-align: center;
                        border: 1px solid green;
                    }
                    .logo {
                        display: block;
                        margin: 0 auto 15px;
                        width: 100px;
                        height: auto;
                    }
                </style>
            </head>
            <body>
                <form action="restablecer_contraseña.php?token=' . $token . '" method="POST">
                    <img src="log.jpg" class="logo">
                    <h1>Restablecer Contraseña</h1>
                    <p><h4>Nueva Contraseña</h4>
                    <input type="password" name="password" id="password" required></p>
                    <p><input type="submit" value="Restablecer Contraseña"></p>
                </form>
            </body>
            </html>';
        }
    } else {
        // Si el token no es válido
        echo "El token no es válido o ha expirado.";
    }
} else {
    // Si no se pasa un token en la URL
    echo "No se proporcionó un token.";
}
?>
