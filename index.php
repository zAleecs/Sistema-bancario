<?php
session_start(); // Iniciamos la sesión

include_once 'includes/user.php';
include_once 'includes/user_session.php';

$userSession = new UserSession();
$user = new User();

// Inicializar el contador de intentos si no existe
if (!isset($_SESSION['intentos'])) {
    $_SESSION['intentos'] = 0;
}

if (isset($_SESSION['user'])) {
    // Si ya está logueado, obtenemos su nombre
    $user->setUser($userSession->getCurrentUser());
    $_SESSION['nombre'] = $user->getNombre(); // Guardamos el nombre en la sesión
    include_once 'home.php';
} else if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($_SESSION['intentos'] >= 2) {
        // Si superó los intentos permitidos, destruir la sesión y cerrar la página
        session_destroy();
        die("Has superado el número máximo de intentos. Cierra y vuelve a abrir la página.");
    }

    $userForm = $_POST['username'];
    $passForm = $_POST['password'];

    if ($user->userExists($userForm, $passForm)) {
        // Si el usuario es validado, restablecemos los intentos y lo logueamos
        $_SESSION['intentos'] = 0;
        $userSession->setCurrentUser($userForm);
        $user->setUser($userForm);
        $_SESSION['nombre'] = $user->getNombre(); // Guardamos el nombre en la sesión
        include_once 'home.php';
    } else {
        // Incrementamos el contador de intentos
        $_SESSION['intentos']++;
        $errorLogin = "Nombre de usuario y/o password incorrecto. Intento " . $_SESSION['intentos'] . " de 3.";
        include_once 'vistas/login.php';
    }
} else {
    include_once 'vistas/login.php';
}
?>
