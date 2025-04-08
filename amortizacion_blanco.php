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

// Validar que existen los datos
if (!isset($_GET['monto'], $_GET['plazo'], $_GET['cliente_id'])) {
    die("Faltan datos para generar la amortización.");
}

$monto = floatval($_GET['monto']);
$plazo = $_GET['plazo'];
$cliente_id = $_GET['cliente_id'];

// Obtener datos del cliente
$stmt = $pdo->prepare("SELECT nombre, app, apm FROM clientes WHERE id = ?");
$stmt->execute([$cliente_id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

// Parámetros de amortización
$interes_anual = 0.75;
switch ($plazo) {
    case 'quincenal':
        $periodos = 24;
        $interes_periodo = pow(1 + $interes_anual, 1/24) - 1;
        break;
    case 'mensual':
        $periodos = 12;
        $interes_periodo = pow(1 + $interes_anual, 1/12) - 1;
        break;
    case 'anual':
        $periodos = 1;
        $interes_periodo = $interes_anual;
        break;
    default:
        die("Plazo no válido.");
}

// Calcular cuota
$cuota = $monto * pow(1 + $interes_periodo, $periodos) * $interes_periodo / (pow(1 + $interes_periodo, $periodos) - 1);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de Amortización</title>
    <link rel="stylesheet" href="style.css"> <!-- Usa tu estilo -->
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    height: 100vh;
    background-color: #f4f4f4;
}


.main-content {
    margin-left: 250px; /* Deja espacio para el sidebar */
    flex-grow: 1;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    flex-direction: column;
    width: 100%;
}

.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    padding: 20px;
    text-align: center;
}

.table-container {
    width: 100%;
    max-width: 800px;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-left: 280px; /* Aumenta este valor para mover la tabla más a la derecha */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px 12px;
    text-align: center;
}

th {
    background-color: #f2f2f2;
}

.menu-btn, .sidebar-btn {
    cursor: pointer;
    padding: 10px;
}

footer {
    position: absolute;
    bottom: 0;
    width: 100%;
}

    </style>
</head>
<body>

<div class="container">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th colspan="5">Datos del Cliente</th>
                </tr>
                <tr>
                    <th>Cliente</th>
                    <th>Monto</th>
                    <th>Plazo</th>
                    <th>Interés Anual</th>
                    <th>Cuota</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $cliente['nombre'] . ' ' . $cliente['app'] . ' ' . $cliente['apm'] ?></td>
                    <td>$<?= number_format($monto, 2) ?></td>
                    <td><?= ucfirst($plazo) ?></td>
                    <td><?= $interes_anual * 100 ?>%</td>
                    <td>$<?= number_format($cuota, 2) ?></td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Periodo</th>
                    <th>Pago</th>
                    <th>Interés</th>
                    <th>Abono Capital</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $saldo = $monto;
                for ($i = 1; $i <= $periodos; $i++) {
                    $interes = $saldo * $interes_periodo;
                    $abono = $cuota - $interes;
                    $saldo -= $abono;
                ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td>$<?= number_format($cuota, 2) ?></td>
                        <td>$<?= number_format($interes, 2) ?></td>
                        <td>$<?= number_format($abono, 2) ?></td>
                        <td>$<?= number_format(max($saldo, 0), 2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

</main>
    <script src="script.js"></script>
</body>
</html>