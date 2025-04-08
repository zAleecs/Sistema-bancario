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
        
                    
        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
   
</head>
<body>

    <h2>Lista de Usuarios</h2>
    <br>
    
    <table id="tablaUsuarios" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th> <!-- Nueva columna para los botones -->
            </tr>
        </thead>
    </table>

    <script>
        $(document).ready(function () {
            $('#tablaUsuarios').DataTable({
                "ajax": {
                    "url": "obtener_usuarios.php",
                    "dataSrc": "data"
                },
                "columns": [
                    { "data": "id" },
                    { "data": "nombre" },
                    { "data": "app" },
                    { "data": "username" },
                    { "data": "password" },
                    { "data": "email" },
                    { "data": "rol" },
                    {
                        "data": null,
                        "defaultContent": '<button class="editar custom-btn editar-btn">Editar</button> <button class="eliminar custom-btn eliminar-btn">Eliminar</button>',
                        "orderable": false
                    }
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });
    
            // Evento para el botón Editar
            $('#tablaUsuarios').on('click', '.editar', function() {
                var id = $(this).closest('tr').find('td').eq(0).text(); // Obtener el ID de la primera columna
                window.location.href = 'editar_usuarios.php?id=' + id; // Redirige al archivo de edición
            });
    
            // Evento para el botón Eliminar
            $('#tablaUsuarios').on('click', '.eliminar', function() {
                var id = $(this).closest('tr').find('td').eq(0).text(); // Obtener el ID de la primera columna
                if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                    window.location.href = 'eliminar_usuarios.php?id=' + id; // Redirige al archivo de eliminación
                }
            });
        });
    </script>
    
    <style>
        .custom-btn {
            padding: 8px 16px; /* Espaciado interno uniforme */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            color: white;
            width: 90px; /* Ancho fijo */
            height: 35px; /* Altura fija */
            text-align: center; /* Centra el texto dentro del botón */
            line-height: 24px; /* Asegura que el texto esté centrado verticalmente */
        }
    
        .editar-btn {
            background-color: #007bff; /* Azul */
        }
    
        .editar-btn:hover {
            background-color: #0056b3; /* Azul oscuro en hover */
        }
    
        .eliminar-btn {
            background-color: #dc3545; /* Rojo */
        }
    
        .eliminar-btn:hover {
            background-color: #c82333; /* Rojo oscuro en hover */
        }
    </style>
    

</body>
</html>



    </main>
    <script src="script.js"></script>
</body>
</html>