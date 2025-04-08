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
                <li class="menu-item menu-item-dropdown active">
                    <a href="#" class="menu-link">
                        <i class='bx bx-pen' ></i>
                        <span>Solicitudes</span>
                        <i class='bx bx-chevron-down'></i>
                    </a>
                    <ul class="sub-menu">
                    <li><a href="solicitudes.php" class="sub-menu-link">Registrar solicitud</a></li>
                    <li><a href="consulta_solicitudes.php" class="sub-menu-link">Consultar prestamos</a></li>
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
    <script src="script.js"></script>
</body>
</html>


<?php
// Suponiendo que ya has hecho la conexión a la base de datos
include('conexion.php');

// Obtener todas las solicitudes de préstamos
$query = "SELECT * FROM solicitudes";
$stmt = $pdo->prepare($query);
$stmt->execute();
$solicitudes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Solicitudes de Préstamo</title>

    <!-- Enlace a CSS de DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <!-- Enlace a jQuery (necesario para DataTables) -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Enlace a JS de DataTables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <style>
        /* Aquí puedes añadir estilos personalizados para la tabla */
        .table-container {
            width: 100%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .table td {
            font-size: 16px;
        }

        .table td:nth-child(1), .table th:nth-child(1) {
            width: 120px;
        }

        .table td:nth-child(5), .table th:nth-child(5) {
            width: 150px;
        }
    </style>
</head>
<body>
<main>
    <div class="table-container">
        <h2 class="table-title">Listado de Solicitudes de Préstamo</h2>

        <table id="solicitudesTable" class="table">
            <thead>
                <tr>
                    <th>ID Solicitud</th>
                    <th>Cliente</th>
                    <th>Monto Solicitado</th>
                    <th>Plazo</th>
                    <th>Monto Final</th>
                    <th>Fecha Solicitud</th>
                    <th>Pago por Periodo</th>
                    <th>Generar PDF</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($solicitudes) > 0): ?>
                    <?php foreach ($solicitudes as $solicitud): ?>
                        <?php
                        // Calcular el pago por periodo
                        switch ($solicitud['plazo']) {
                            case 'quincenal':
                                $num_pagos = 26;
                                break;
                            case 'mensual':
                                $num_pagos = 12;
                                break;
                            case 'anual':
                                $num_pagos = 1;
                                break;
                            default:
                                $num_pagos = 0;
                        }
                        $pago_periodo = $solicitud['monto_final'] / $num_pagos;
                        ?>
                        <tr>
                            <td><?php echo $solicitud['id']; ?></td>
                            <td><?php echo $solicitud['nombre'] . ' ' . $solicitud['app'] . ' ' . $solicitud['apm']; ?></td>
                            <td><?php echo '$' . number_format((float)$solicitud['monto'], 2); ?></td>
                            <td><?php echo ucfirst($solicitud['plazo']); ?></td>
                            <td><?php echo '$' . number_format((float)$solicitud['monto_final'], 2); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($solicitud['fecha_solicitud'])); ?></td>
                            <td><?php echo '$' . number_format((float)$pago_periodo, 2); ?></td>
                            <td><a href="generar_pdf.php?id=<?php echo $solicitud['id']; ?>" target="_blank">🖨️ PDF</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No hay solicitudes registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>


    <!-- Inicializar DataTable -->
    <script>
        $(document).ready(function() {
            // Inicia el DataTable en la tabla con ID #solicitudesTable
            $('#solicitudesTable').DataTable({
                // Opcional: Puedes personalizar la configuración si lo deseas
                paging: true,  // Habilitar paginación
                searching: true,  // Habilitar la búsqueda
                ordering: true,  // Habilitar ordenamiento
                language: {
                    search: "Buscar cliente:",
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros en total)"
                }
            });
        });
    </script>
</body>
</html>
