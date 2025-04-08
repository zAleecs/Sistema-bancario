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
                    <li><a href="consulta_solicitudes.php" class="sub-menu-link">Consultar prestamos</a></li>
                    <li><a href="amortizaciones.php" class="sub-menu-link">Consultar amortizacion</a></li>
                    </ul>
                </li>

                <li class="menu-item menu-item-dropdown">
                    <a href="#" class="menu-link">
                        <i class='bx bx-money-withdraw' ></i>
                        <span>Historial</span>
                        <i class='bx bx-chevron-down'></i>
                    </a>
                    <ul class="sub-menu">
                    <li><a href="pagos.php" class="sub-menu-link">Realizar pago</a></li>
                    <li><a href="consulta_pagos.php" class="sub-menu-link">Consultar pagos</a></li>
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
include('conexion.php');

// Obtener solicitudes con datos del cliente
$query = "SELECT s.id, s.monto, s.plazo, c.nombre, c.app, c.apm, s.cliente_id 
          FROM solicitudes s
          JOIN clientes c ON s.cliente_id = c.id";
$stmt = $pdo->query($query);
$solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Tablas de Amortización</title>
    <link rel="stylesheet" href="style.css"> <!-- Usa tu estilo -->
    
    <!-- Incluir CSS de DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    
    <!-- Incluir JS de jQuery (requerido por DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Incluir JS de DataTables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            $('table').DataTable();
        });
    </script>
</head>
<body>
<div class="form-container">
    <h2 class="form-title">Tablas de Amortización</h2>

    <table id="solicitudesTable" class="display" border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Monto</th>
                <th>Plazo</th>
                <th>Acción</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($solicitudes as $index => $s): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $s['nombre'] . ' ' . $s['app'] . ' ' . $s['apm'] ?></td>
                    <td>$<?= number_format($s['monto'], 2) ?></td>
                    <td><?= ucfirst($s['plazo']) ?></td>
                    <td>
                        <a href="amortizacion_pdf.php?cliente_id=<?= $s['cliente_id'] ?>&monto=<?= $s['monto'] ?>&plazo=<?= $s['plazo'] ?>" target="_blank">
                            📄 Ver PDF
                        </a>
                        
 
                        <td> 
                           <!-- Enlace para visualizar la tabla de amortización -->
                        <a href="amortizacion_blanco.php?cliente_id=<?= $s['cliente_id'] ?>&monto=<?= $s['monto'] ?>&plazo=<?= $s['plazo'] ?>" target="_blank">
                        👁️ Visualizar
                         </a>
                        </td>


                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>

</main>
    <script src="script.js"></script>
</body>
</html>