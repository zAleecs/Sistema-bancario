<?php
// Este archivo debe estar en el mismo directorio
header('Content-Type: application/json');

// Obtener los datos enviados por el formulario
$data = json_decode(file_get_contents('php://input'), true);
$monto = isset($data['monto']) ? $data['monto'] : 0;
$plazo = isset($data['plazo']) ? $data['plazo'] : 0;
$tipo_pago = isset($data['tipo_pago']) ? $data['tipo_pago'] : 'mensual';

// Función para calcular la amortización con interés compuesto
function calcularAmortizacion($monto, $plazo, $interes = 0.70, $tipo_pago = 'mensual') {
    // Aseguramos que el plazo no sea mayor a 12 meses
    if ($plazo > 12) {
        $plazo = 12;  // Limitamos el plazo máximo a 12 meses
    }

    $monto = floatval($monto);
    $plazo = intval($plazo);

    // Dependiendo del tipo de pago, ajustamos n (cantidad de pagos por año)
    switch ($tipo_pago) {
        case 'quincenal':
            $n = 24; // Pagos quincenales
            break;
        case 'mensual':
            $n = 12; // Pagos mensuales
            break;
        case 'anual':
            $n = 1;  // Pagos anuales
            break;
        default:
            $n = 12; // Por defecto, mensual
            break;
    }

    $r = $interes;  // Tasa de interés anual 70%
    $t = $plazo / $n;  // El tiempo en años para cada período

    // Formula de interés compuesto
    $saldo = $monto;
    $tabla = [];

    for ($i = 1; $i <= $plazo; $i++) {
        // Calculamos el interés compuesto para el saldo
        $saldo = $monto * pow(1 + $r / $n, $n * $i);

        $tabla[] = [
            'pago' => $i,
            'saldo' => number_format($saldo, 2)
        ];
    }

    return $tabla;
}

$simulacion = calcularAmortizacion($monto, $plazo, 0.70, $tipo_pago);

// Enviar la respuesta en formato JSON
echo json_encode($simulacion);
?>
