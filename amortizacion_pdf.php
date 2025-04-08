<?php
require('fpdf/fpdf.php');
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

// Generar PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(0, 10, 'TABLA DE AMORTIZACION', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(5);
$pdf->Cell(0, 10, 'Cliente: ' . $cliente['nombre'] . ' ' . $cliente['app'] . ' ' . $cliente['apm'], 0, 1);
$pdf->Cell(0, 10, 'Monto: $' . number_format($monto, 2), 0, 1);
$pdf->Cell(0, 10, 'Plazo: ' . ucfirst($plazo), 0, 1);
$pdf->Ln(5);

// Encabezados tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 10, 'Periodo', 1);
$pdf->Cell(40, 10, 'Pago', 1);
$pdf->Cell(40, 10, 'Interes', 1);
$pdf->Cell(40, 10, 'Abono Capital', 1);
$pdf->Cell(40, 10, 'Saldo', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
$saldo = $monto;

for ($i = 1; $i <= $periodos; $i++) {
    $interes = $saldo * $interes_periodo;
    $abono = $cuota - $interes;
    $saldo -= $abono;

    $pdf->Cell(30, 8, $i, 1);
    $pdf->Cell(40, 8, '$' . number_format($cuota, 2), 1);
    $pdf->Cell(40, 8, '$' . number_format($interes, 2), 1);
    $pdf->Cell(40, 8, '$' . number_format($abono, 2), 1);
    $pdf->Cell(40, 8, '$' . number_format(max($saldo, 0), 2), 1);
    $pdf->Ln();
}

$pdf->Output();
?>
