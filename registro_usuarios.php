<?php 

include("con_db.php");
include("func.php");

if (isset($_POST['register'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['n2']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['n1']);
    $username = mysqli_real_escape_string($conexion, $_POST['n3']);
    $password = md5($_POST['n4']); // Encriptación con MD5
    $rol = mysqli_real_escape_string($conexion, $_POST['n5']);

    // Verificar si el usuario ya existe
    $check_user = "SELECT * FROM usuarios WHERE username = '$username'";
    $result = mysqli_query($conexion, $check_user);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('El usuario ya existe.'); window.location='usuarios.php';</script>";
    } else {
        // Consulta segura con preparación de sentencia
        $consulta = "INSERT INTO usuarios (nombre, apellido, username, password, rol) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $consulta);
        mysqli_stmt_bind_param($stmt, "sssss", $nombre, $apellido, $username, $password, $rol);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Usuario registrado exitosamente.'); window.location='usuarios.php';</script>";
        } else {
            echo "<script>alert('Error al registrar usuario.');</script>";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conexion);
}
?>

<a class="btn" href="usuarios.php">Ir a inicio</a>
