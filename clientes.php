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
                <li class="menu-item menu-item-static">
                    <a href="home.php" class="menu-link">
                        <i class='bx bx-home-alt' ></i>
                        <span>Inicio</span>
                    </a>
                </li>
                <li class="menu-item menu-item-dropdown active">
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
    <div class="form-container">
            <form action="registro_clientes.php" method="post">
                <h2 class="form-title">Registro de Clientes</h2>
                <!-- Apellido Paterno, Apellido Materno, Nombre Completo -->
                <div class="input-group">
                    <div class="input-field">
                        <label for="n1">Apellido Paterno</label>
                        <input style="text-transform:uppercase" name="n1" id="paterno" placeholder="">
                    </div>
                    <div class="input-field">
                        <label for="n2">Apellido Materno</label>
                        <input style="text-transform:uppercase" name="n2" id="n2" placeholder="">
                    </div>
                    <div class="input-field">
                        <label for="n3">Nombre Completo</label>
                        <input style="text-transform:uppercase" name="n3" id="n3" placeholder="">
                    </div>
                </div>
    
                <!-- Telefono, Dirección, Número de Casa, Barrio o Colonia -->
                <div class="input-group">
                    <div class="input-field">
                        <label for="n4">Número de telefono</label>
                        <input style="text-transform:uppercase" name="n4" id="n4" placeholder="">
                    </div>
                    <div class="input-field">
                        <label for="n5">Dirección</label>
                        <input style="text-transform:uppercase" name="n5" id="n5" placeholder="">
                    </div>
                    <div class="input-field">
                        <label for="n6">Número de casa</label>
                        <input style="text-transform:uppercase" name="n6" id="n6" placeholder="">
                    </div>
                    <div class="input-field">
                        <label for="n7">Barrio o Colonia</label>
                        <input style="text-transform:uppercase" name="n7" id="n7" placeholder="">
                    </div>
                </div>
    
                <!-- Matrícula, Fecha de Nacimiento, Lugar de Nacimiento -->
                <div class="input-group">
                    <div class="input-field">
                        <label for="n8">Correo electronico</label>
                        <input style="text-transform:uppercase" name="n8" id="n8" placeholder="">
                    </div>
                    <div class="input-field">
                        <label for="n9">Fecha de nacimiento</label>
                        <input type="date" name="n9" id="n9" placeholder="">
                    </div>
                    <div class="input-field">
                        <label for="n10">Lugar de nacimiento</label>
                        <input style="text-transform:uppercase" name="n10" id="n10" placeholder="">
                    </div>
                </div>
    
                <!-- Estado, Ciclo Escolar -->
                <div class="input-group">
                    <div class="input-field">
                        <label for="n11">Estado</label>
                        <input style="text-transform:uppercase" name="n11" id="n11" placeholder="">
                    </div>
                    <div class="input-field">
                        <label for="n12">R.F.C</label>
                        <input style="text-transform:uppercase" name="n12" id="n12" placeholder="">
                    </div>
                    <div class="input-field">
                        <label for="n13">C.U.R.P</label>
                        <input style="text-transform:uppercase" name="n13" id="n13" placeholder="">
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-field">
                        <label for="n14">Sueldo mensual base</label>
                        <input style="text-transform:uppercase" name="n14" id="n14" placeholder="">
                    </div>
                    <div class="input-field">
                        <label for="n15">Historial Crediticio</label>
                        <input style="text-transform:uppercase" name="n15" id="n15" placeholder="">
                    </div>
                </div>
    
                <button type="submit" class="submit-btn" name="register">Enviar</button>
            </form>
        </div>
    </main>
    
    <script src="script.js"></script>
</body>
</html>