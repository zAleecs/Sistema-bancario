<?php
ob_start(); // Inicia el búfer de salida
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

// Incluye la conexión a la base de datos
include('conexion.php');

// Verifica si se ha recibido el ID de la solicitud
if (isset($_GET['id'])) {
    $id_solicitud = $_GET['id'];

    // Obtener la solicitud de la base de datos
    $query = "SELECT * FROM solicitudes WHERE id = :id_solicitud";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_solicitud', $id_solicitud);
    $stmt->execute();
    $solicitud = $stmt->fetch();

    // Si no existe la solicitud
    if (!$solicitud) {
        echo "Solicitud no encontrada.";
        exit;
    }

    // Obtener la cantidad de pagos realizados
    $pagos_realizados = $solicitud['pagos_realizados'];

    // Calcular el número de pagos según el plazo
    switch ($solicitud['plazo']) {
        case 'quincenal':
            $num_pagos = 26; // 26 pagos en un año
            break;
        case 'mensual':
            $num_pagos = 12; // 12 pagos en un año
            break;
        case 'anual':
            $num_pagos = 1; // 1 pago en el año
            break;
        default:
            $num_pagos = 0; // En caso de que no esté definido
    }

    // Verificar si ya se han completado todos los pagos
    if ($pagos_realizados >= $num_pagos) {
        echo "Todos los pagos ya han sido realizados.";
        header("Refresh: 2; url=pagos.php");
        exit;
    }

    // Calcular el pago por periodo
    $pago_periodo = $solicitud['monto_final'] / $num_pagos;

    // Calcula deuda restante
    $deuda_restante = $solicitud['monto_final'] - ($pago_periodo * $pagos_realizados);

    // Si se ha confirmado el pago
    if (isset($_POST['confirmar_pago'])) {
        // Obtener el monto del pago ingresado
        $monto_pago = $_POST['monto_pago'];

        // Verificar que el monto no sea menor al pago por periodo
        if ($monto_pago < $pago_periodo) {
            echo "<p>El monto a pagar no puede ser menor a $".number_format($pago_periodo, 2).".</p>";
        } else {
            // Insertar el pago en la tabla "pagos"
            $query_pago = "INSERT INTO pagos (id_solicitud, monto_pago, fecha_pago) VALUES (:id_solicitud, :monto_pago, NOW())";
            $stmt_pago = $pdo->prepare($query_pago);
            $stmt_pago->bindParam(':id_solicitud', $id_solicitud);
            $stmt_pago->bindParam(':monto_pago', $monto_pago);
            $stmt_pago->execute();

            // Actualizar la cantidad de pagos realizados en la tabla "solicitudes"
            $query_actualizar = "UPDATE solicitudes SET pagos_realizados = pagos_realizados + 1 WHERE id = :id_solicitud";
            $stmt_actualizar = $pdo->prepare($query_actualizar);
            $stmt_actualizar->bindParam(':id_solicitud', $id_solicitud);
            $stmt_actualizar->execute();

            // Mostrar mensaje de éxito
            echo "<p>Pago realizado con éxito.</p>";

            // Redirigir a pagos.php después de 2 segundos
            header("Refresh: 2; url=pagos.php");
            exit;
        }
    }
} else {
    echo "No se ha recibido el ID de la solicitud.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Pago</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content-container">
        <h2>Generar Pago para la Solicitud #<?php echo $solicitud['id']; ?></h2>

        <p><strong>Cliente:</strong> <?php echo $solicitud['nombre'] . ' ' . $solicitud['app'] . ' ' . $solicitud['apm']; ?></p>
        <p><strong>Monto Solicitado:</strong> $<?php echo number_format($solicitud['monto'], 2); ?></p>
        <p><strong>Monto Final:</strong> $<?php echo number_format($solicitud['monto_final'], 2); ?></p>
        <p><strong>Deuda Restante:</strong> $<?php echo number_format($deuda_restante, 2); ?></p>
        <p><strong>Plazo:</strong> <?php echo ucfirst($solicitud['plazo']); ?></p>
        <p><strong>Pagos Realizados:</strong> <?php echo $pagos_realizados; ?> de <?php echo $num_pagos; ?> pagos.</p>
        <p><strong>Pago por Periodo:</strong> $<?php echo number_format($pago_periodo, 2); ?></p>

        <?php if ($pagos_realizados < $num_pagos): ?>
            <form method="POST">
                <label for="monto_pago">Monto a Pagar:</label>
                <input type="number" step="0.01" id="monto_pago" name="monto_pago" value="<?php echo number_format($pago_periodo, 2); ?>" min="<?php echo number_format($pago_periodo, 2); ?>" required>
                <button type="submit" name="confirmar_pago">Confirmar Pago</button>
            </form>
        <?php else: ?>
            <p>Todos los pagos ya han sido realizados.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<style>

/* Estilo para el main, asegurando que esté centrado */
main {
    display: flex;
    justify-content: flex-start; /* Mantiene el contenido alineado al principio (izquierda) */
    align-items: center;         /* Centrado vertical */
    height: 100vh;               /* Ocupa toda la altura de la pantalla */
    margin-left: 500px;          /* Agrega un margen izquierdo para mover el contenido a la derecha */
}


/* Contenedor del contenido */
.content-container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 30px;
    width: 100%;
    max-width: 800px; /* Limita el tamaño máximo del contenedor */
    text-align: left;
    box-sizing: border-box;
}

/* Títulos */
h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

/* Estilo de los párrafos */
p {
    font-size: 16px;
    color: #555;
    margin-bottom: 10px;
}

strong {
    font-weight: bold;
}

/* Estilo del botón */
button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

/* Estilo del campo de entrada */
input[type="number"] {
    padding: 10px;
    font-size: 16px;
    width: 100%;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

</style>

    </main>
    <script src="script.js"></script>
</body>
</html>

