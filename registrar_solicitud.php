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
include('conexion.php');

// Verifica si la sesión está activa y si el cliente fue seleccionado
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$id_cliente = isset($_GET['id']) ? $_GET['id'] : null;
if ($id_cliente) {
    $query = "SELECT * FROM clientes WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_cliente]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        $nombre = $cliente['nombre'];
        $app = $cliente['app'];
        $apm = $cliente['apm'];
        $rfc = $cliente['rfc'];
    } else {
        echo "Cliente no encontrado.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['simular'])) {
    $monto = $_POST['monto'];
    $plazo = $_POST['plazo'];
    
    // Tasa de interés compuesto anual (75%)
    $tasa_interes = 0.75; // 75% anual
    $num_pagos = 0;
    $intervalo = '';

    if ($plazo == 'quincenal') {
        $num_pagos = 26; // Quincenal: 26 pagos al año
        $intervalo = 'Quincenal';
    } elseif ($plazo == 'mensual') {
        $num_pagos = 12; // Mensual: 12 pagos al año
        $intervalo = 'Mensual';
    } elseif ($plazo == 'anual') {
        $num_pagos = 1; // Anual: 1 pago al año
        $intervalo = 'Anual';
    }

    // Cálculo de la cuota usando interés compuesto
    $interes_periodo = $tasa_interes / $num_pagos;
    $cuota = $monto * ($interes_periodo * pow(1 + $interes_periodo, $num_pagos)) / (pow(1 + $interes_periodo, $num_pagos) - 1);

    // Generar la tabla de amortización
    $amortizacion = [];
    $saldo = $monto;
    $total_intereses = 0;

    for ($i = 1; $i <= $num_pagos; $i++) {
        $intereses = $saldo * $interes_periodo;
        $abono_capital = $cuota - $intereses;
        $saldo -= $abono_capital;
        $total_intereses += $intereses;

        $amortizacion[] = [
            'pago' => $i,
            'cuota' => round($cuota, 2),
            'intereses' => round($intereses, 2),
            'abono_capital' => round($abono_capital, 2),
            'saldo_restante' => round($saldo, 2)
        ];
    }

    // Calcular el total a pagar (monto inicial + total intereses)
    $total_a_pagar = $monto + $total_intereses;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulación de Préstamo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2 class="form-title">Solicitar o Simular Préstamo</h2>
    
    <!-- Formulario para Solicitar el Préstamo -->
    <form action="procesar_solicitud.php" method="POST">
        <div class="input-group">
            <div class="input-field">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre . ' ' . $app . ' ' . $apm; ?>" readonly>
            </div>

            <div class="input-field">
                <label for="rfc">RFC:</label>
                <input type="text" id="rfc" name="rfc" value="<?php echo $rfc; ?>" readonly>
            </div>
        </div>

        <div class="input-field">
            <label for="monto">Monto Solicitado:</label>
            <input type="text" id="monto" name="monto" required>
        </div>

        <div class="input-field">
            <label for="plazo">Plazo:</label>
            <select id="plazo" name="plazo" required>
                <option value="quincenal">Quincenal</option>
                <option value="mensual">Mensual</option>
                <option value="anual">Anual</option>
            </select>
        </div>

        <button type="submit" class="submit-btn" name="register" class="btn">Solicitar Préstamo</button>
    </form>

    <!-- Simulador de préstamo: campos para monto y plazo -->
    <h3>Simular Préstamo</h3>
    <form method="POST">
        <div class="input-field">
            <label for="monto_simulacion">Monto Solicitado:</label>
            <input type="text" id="monto_simulacion" name="monto" required>
        </div>

        <div class="input-field">
            <label for="plazo_simulacion">Plazo:</label>
            <select id="plazo_simulacion" name="plazo" required>
                <option value="quincenal">Quincenal</option>
                <option value="mensual">Mensual</option>
                <option value="anual">Anual</option>
            </select>
        </div>

        <button type="submit" class="submit-btn" name="simular">Simular Préstamo</button>
    </form>

    <!-- Mostrar los resultados de la simulación -->
    <?php if (isset($amortizacion)) { ?>
    <div class="simulacion-resultados">
        <h3>Tabla de Amortización</h3>
        <table>
            <thead>
                <tr>
                    <th>Pago #</th>
                    <th>Cuota</th>
                    <th>Intereses</th>
                    <th>Abono a Capital</th>
                    <th>Saldo Restante</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($amortizacion as $pago) { ?>
                <tr>
                    <td><?php echo $pago['pago']; ?></td>
                    <td><?php echo "$" . $pago['cuota']; ?></td>
                    <td><?php echo "$" . $pago['intereses']; ?></td>
                    <td><?php echo "$" . $pago['abono_capital']; ?></td>
                    <td><?php echo "$" . $pago['saldo_restante']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <p>Total Intereses: $<?php echo round($total_intereses, 2); ?></p>
        <p><strong>Total a Pagar: $<?php echo round($total_a_pagar, 2); ?></strong></p>
    </div>
    <?php } ?>
</div>
</body>
</html>

<style>
    /* El estilo puede seguir siendo el mismo que ya tienes, solo agrega el estilo para la tabla */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .simulacion-resultados {
        margin-top: 30px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
    }

    .form-container {
        margin-bottom: 40px;
    }
</style>



    </main>
    <script src="script.js"></script>
</body>
</html>
