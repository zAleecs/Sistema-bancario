<?php
// Verifica si la sesión no está iniciada antes de llamarla
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica si la sesión está activa, si no lo está, redirige al login
if (!isset($_SESSION['user'])) {
    header("Location: index.php");  // Redirige al formulario de login
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechZone</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="menu-btn sidebar-btn" id="sidebar-btn">
        <i class='bx bx-menu'></i>
        <i class='bx bx-x'></i>
    </div>

    <div class="dark-mode-btn" id="dark-mode-btn">
      
    </div>
    
    <div class="sidebar" id="sidebar">
        <div class="header">
            <div class="menu-btn" id="menu-btn">
                <i class='bx bx-chevron-left'></i>
            </div>
            <div class="brand">
                <img class="brand-light" src="log.jpg" alt="logo">
                <span>TECHZONE</span>
            </div>
        </div>
        <div class="footer"></div>
        <div class="menu-container">
            <br>
            <ul class="menu">
                <li class="menu-item menu-item-static active">
                    <a href="home.php" class="menu-link">
                        <i class='bx bx-home-alt' ></i>
                        <span>Inicio</span>
                    </a>
                </li>
                <li class="menu-item menu-item-dropdown">
                    <a href="#" class="menu-link">
                        <i class='bx bx-edit-alt' ></i>
                        <span>Clientes</span>
                        <i class='bx bx-chevron-down'></i>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="clientes.php" class="sub-menu-link">Registrar clientes</a></li>
                        <li><a href="consulta_clientes.php" class="sub-menu-link">Consultar registros de clientes</a></li>
                    </ul>
                </li>
                <li class="menu-item menu-item-dropdown">
                    <a href="#" class="menu-link">
                        <i class='bx bx-pen' ></i>
                        <span>Solicitudes</span>
                        <i class='bx bx-chevron-down'></i>
                    </a>
                    <ul class="sub-menu">
                    <li><a href="solicitudes.php" class="sub-menu-link">Registrar solicitud</a></li>
                    <li><a href="consulta_catedraticos.php" class="sub-menu-link">Consultar prestamos</a></li>
                    </ul>
                </li>

                <li class="menu-item menu-item-dropdown">
                    <a href="#" class="menu-link">
                        <i class='bx bx-money-withdraw' ></i>
                        <span>Historial</span>
                        <i class='bx bx-chevron-down'></i>
                    </a>
                    <ul class="sub-menu">
                    <li><a href="catedraticos.php" class="sub-menu-link">Realizar pago</a></li>
                    <li><a href="consulta_catedraticos.php" class="sub-menu-link">Consultar pagos</a></li>
                    </ul>
                </li>


                <!--ESTO IRÁ DESPUES DE LAS DEMÁS OPCIONES-->
                <li class="menu-item menu-item-dropdown">
                    <a href="#" class="menu-link">
                        <i class='bx bx-shield-alt-2' ></i>
                        <span>Usuarios</span>
                        <i class='bx bx-chevron-down'></i>
                    </a>
                    <ul class="sub-menu">
                    <li><a href="usuarios.php" class="sub-menu-link">Registrar usuarios</a></li>
                    <li><a href="consulta_usuarios.php" class="sub-menu-link">Consultar usuarios</a></li>
                    </ul>
                </li>


            </ul>
        </div>
        <div class="footer">
            <div class="user">
                <div class="user-img">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAARtJREFUSEvF1c8qRVEUx/HPNZFHkCIMGCp5AGMDE94ExQQlEU9jYGjOjImZf8kzyIS7at+6jrtv5292nU6dtffvu9Zv7bN3T8ej17G+ImATZ1iuCX7EDq4H64uAd8zUFB8se8JiDvCdAnWt+7O+KPSvgG2cIJLYw9UIKxtV8IHpJPqMhbYBwxvgDXNtA7Zwiq/+c9CFRWV2b+0erKYGryXKbarivkCtBQjxO0wUxMKqFcTfOxi1ADdYz/gTR8JGU8AnJjOAiE01BZRpbiOLWgW8YjajeNz/fpRi8T7MzHvBfO40jfvgHEtjIBHKiT9gf9x9kLNjVMbDFWVtrHLuX6TbKsQusVumOVUAoReQGKXEY2JVQJmkf83pHPADCEdAGWcp8PYAAAAASUVORK5CYII="/>
                </div>
                <div class="user-data">
                    <span class="name">
                        <h4>Bienvenid@</h4>
                     <?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario'; ?></span>
                     
                    
                    
                </div>
                <div class="user-icon">
                    <a href="includes/logout.php">
                        <i class="bx bx-exit"></i>
                      </a>
                </div>
            </div>
        </div>
    </div>


    <main>
    <?php
// Conexión a la base de datos (ajusta según tu configuración)
$host = 'localhost';
$dbname = 'techzone';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Obtener el ID de la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del alumno para editar
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no se encuentra el alumno, redirigir o mostrar un mensaje de error
    if (!$usuario) {
        die("usuario no encontrado.");
    }
} else {
    die("ID no proporcionado.");
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario y convertirlos a mayúsculas
    $app = $_POST['app'];
    $nombre = $_POST['nombre'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Encripta la contraseña en MD5 antes de guardarla
    $email = $_POST['email'];
    $rol = $_POST['rol'];


    // Actualizar los datos en la base de datos
    $updateStmt = $pdo->prepare("UPDATE usuarios SET app = :app, nombre = :nombre, username = :username, email = :email, password = :password, rol = :rol WHERE id = :id");
    $updateStmt->bindParam(':app', $app);
    $updateStmt->bindParam(':nombre', $nombre);
    $updateStmt->bindParam(':username', $username);
    $updateStmt->bindParam(':password', $password);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->bindParam(':rol', $rol);
    $updateStmt->bindParam(':id', $id);


    if ($updateStmt->execute()) {
        echo "<script>alert('Usuario actualizado correctamente'); window.location.href = 'consulta_usuarios.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuarios</title>
</head>
<body>
<div class="form-container-editar">
<h2 class="form-title">Editar usuario</h2>
<link rel="stylesheet" href="style.css">
    <form method="POST">
    <div class="input-group">
    <div class="input-field">
        <label for="app">Apellido Paterno:</label>
        <input style="text" name="apellido" id="apellido" value="<?= htmlspecialchars($usuario['app']) ?>" required><br><br>
        </div>
        <div class="input-field">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required><br><br>
        </div>
        <div class="input-field">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($usuario['username']) ?>" required><br><br>
        </div>
        </div>


        <div class="input-group">
        <div class="input-field">
        <label for="password">Password:</label>
        <input type="text" name="password" id="password" value="<?= htmlspecialchars($usuario['password']) ?>" required><br><br>
        </div>
        <div class="input-field">
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?= htmlspecialchars($usuario['email']) ?>" required><br><br>
        </div>
        <div class="input-field">
        <label for="rol">Rol:</label>
        <input type="text" name="rol" id="rol" value="<?= htmlspecialchars($usuario['rol']) ?>" required><br><br>
        </div>
        </div>

        
        <button type="submit" class="submit-btn" name="register">Enviar</button>
    </form>
    </div>
</body>
</html>

    </main>
    <script src="script.js"></script>
</body>
</html>