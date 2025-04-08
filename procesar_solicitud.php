<?php
include('conexion.php');

if (isset($_POST['register'])) {
    // Validar y obtener datos del formulario
    $monto = isset($_POST['monto']) ? floatval($_POST['monto']) : 0;
    $plazo = isset($_POST['plazo']) ? $_POST['plazo'] : '';
    $cliente_id = isset($_POST['cliente_id']) ? intval($_POST['cliente_id']) : 0;

    // Validaciones
    if ($monto <= 0 || !$cliente_id) {
        echo "Datos inválidos.";
        exit;
    }

    // 1. Verificar si el cliente tiene alguna solicitud activa
    try {
        $query_verificar = "SELECT * FROM solicitudes WHERE cliente_id = ? AND monto_final > monto_pagado";
        $stmt_verificar = $pdo->prepare($query_verificar);
        $stmt_verificar->execute([$cliente_id]);
        $solicitudes = $stmt_verificar->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($solicitudes)) {
            // Si hay solicitudes, verificar si el cliente ha pagado más del 70%
            foreach ($solicitudes as $solicitud) {
                $monto_final = $solicitud['monto_final'];
                $monto_pagado = $solicitud['monto_pagado']; // Asegúrate de que este campo esté siendo actualizado correctamente

                // 2. Calcular el porcentaje pagado
                $porcentaje_pagado = ($monto_pagado / $monto_final) * 100;

                // 3. Si el cliente no ha pagado más del 70%, mostrar mensaje y no permitir solicitar otro préstamo
                if ($porcentaje_pagado < 70) {
                    echo "<script>alert('El cliente debe haber pagado al menos el 70% de su préstamo anterior para solicitar otro.'); window.location.href = 'registrar_solicitud.php?id=$cliente_id';</script>";
                    exit;
                }
            }
        } else {
            // Si no hay solicitudes, permitir el préstamo
            echo "El cliente no tiene préstamos activos, puede solicitar uno nuevo.";
        }

    } catch (PDOException $e) {
        echo "Error al verificar el préstamo actual: " . $e->getMessage();
        exit;
    }

    // Obtener nombre, apellidos y RFC del cliente
    try {
        $query_cliente = "SELECT nombre, app, apm, rfc FROM clientes WHERE id = ?";
        $stmt_cliente = $pdo->prepare($query_cliente);
        $stmt_cliente->execute([$cliente_id]);
        $cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            $nombre = $cliente['nombre'];
            $app = $cliente['app'];  // Apellido Paterno
            $apm = $cliente['apm'];  // Apellido Materno
            $rfc = $cliente['rfc'];
        } else {
            echo "Cliente no encontrado.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error al obtener los datos del cliente: " . $e->getMessage();
        exit;
    }

    // Tasa de interés anual (75%)
    $tasa_interes = 0.75;

    // Definir número de periodos y calcular tasa periódica
    switch ($plazo) {
        case 'quincenal':
            $n = 26;  // 26 quincenas por año
            break;
        case 'mensual':
            $n = 12;  // 12 meses por año
            break;
        case 'anual':
            $n = 1;   // 1 periodo por año
            break;
        default:
            echo "Plazo no válido.";
            exit;
    }

    // Calcular la tasa periódica
    $tasa_periodica = $tasa_interes / $n;

    // Calcular el monto final con interés compuesto
    $interes_compuesto = $monto * pow((1 + $tasa_periodica), $n);

    // Redondear el monto final
    $monto_final = round($interes_compuesto, 2);

    // Insertar datos en la base de datos
    try {
        // Asegúrate de insertar los valores en el orden correcto
        $query = "INSERT INTO solicitudes (cliente_id, nombre, app, apm, rfc, monto, plazo, monto_final) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$cliente_id, $nombre, $app, $apm, $rfc, $monto, $plazo, $monto_final]);

        // Redirige al archivo que generará el PDF
        header("Location: amortizacion_pdf.php?cliente_id=$cliente_id&monto=$monto&plazo=$plazo");
        exit;
    } catch (PDOException $e) {
        echo "Error en la inserción: " . $e->getMessage();
        exit;
    }
}
?>
