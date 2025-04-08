<?php
// Incluir las librerías de PHPMailer y la base de datos
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'includes/db.php';  // Tu archivo de conexión a la base de datos

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Crear una instancia de PHPMailer
$mail = new PHPMailer(true);

// Procesar la solicitud de recuperación de contraseña
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Verificar si el correo existe en la base de datos (es importante que implementes esto)
    $db = new DB();
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Generar un token único
        $token = bin2hex(random_bytes(16));  // Generar un token aleatorio

        // Guardar el token en la base de datos junto con el correo del usuario
        $stmt = $conn->prepare("UPDATE usuarios SET token = :token WHERE email = :email");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Enviar el correo con el token
        enviarCorreoRecuperacion($email, $token);
    } else {
        echo "<div class='mensaje-error'>Correo no encontrado en nuestra base de datos.</div>";
    }
}

// Función para enviar el correo
function enviarCorreoRecuperacion($email, $token) {
    global $mail;

    try {
        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alexismoralesyt1998@gmail.com';  // Tu correo de Gmail
        $mail->Password = 'rrsv zsol snax oehk';   // Contraseña de aplicación de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('tu-email@gmail.com', 'TECHZONE');
        $mail->addAddress($email);  // El correo del usuario

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Recuperar Password';
        $mail->Body    = "Hola, te hablamos de TECHZONE y haz solicitado recuperar tu contraseña. Para poder restablecerla, haz clic en el siguiente enlace: <br>
                  <a href='http://localhost/Alf/restablecer_contraseña.php?token=$token'>Restablecer Contraseña</a>";

        // Enviar el correo
        $mail->send();
        echo "<div class='mensaje-exito'>Correo enviado para restablecer la contraseña. Favor de revisar su correo y cerrar esta pestaña</div>";
    } catch (Exception $e) {
        echo "<div class='mensaje-error'>Error al enviar el correo: {$mail->ErrorInfo}</div>";
    }
}
?>

<!-- Estilos CSS para centrar y mostrar en rojo el mensaje -->
<style>
    .mensaje-exito {
        color: red;
        font-size: 44px;
        text-align: center;
        margin-top: 250px;
        font-weight: bold;
    }

    .mensaje-error {
        color: red;
        font-size: 18px;
        text-align: center;
        margin-top: 20px;
        font-weight: bold;
    }
</style>
