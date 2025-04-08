<?php
// Incluir la librería FPDF
require('fpdf/fpdf.php');

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

    // Obtener los pagos realizados
    $query_pagos = "SELECT * FROM pagos WHERE id_solicitud = :id_solicitud";
    $stmt_pagos = $pdo->prepare($query_pagos);
    $stmt_pagos->bindParam(':id_solicitud', $id_solicitud);
    $stmt_pagos->execute();
    $pagos = $stmt_pagos->fetchAll();

    // Crear el PDF
    $pdf = new FPDF();
    
    // Función para agregar la imagen de fondo
    function addBackground($pdf) {
        $pdf->Image('images/hoja_membretada.jpg', 0, 0, 210, 297); // Tamaño A4 (210mm x 297mm)
    }
    
    // Agregar primera página
    $pdf->AddPage();
    addBackground($pdf);

    // Título
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetY(20); // Ajustar la posición vertical para el título
    $pdf->Cell(190, 23, 'INFORMACION DE PAGO TECHZONE', 0, 1, 'C');
    
    // Información de la solicitud
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetY(40); // Ajustar la posición vertical para el contenido
    $pdf->Cell(50, 10, 'Cliente:');
    $pdf->Cell(140, 10, $solicitud['nombre'] . ' ' . $solicitud['app'] . ' ' . $solicitud['apm'], 0, 1);
    $pdf->Cell(50, 10, 'Monto Solicitado:');
    $pdf->Cell(140, 10, '$' . number_format($solicitud['monto'], 2), 0, 1);
    $pdf->Cell(50, 10, 'Monto Final:');
    $pdf->Cell(140, 10, '$' . number_format($solicitud['monto_final'], 2), 0, 1);
    $pdf->Cell(50, 10, 'Plazo:');
    $pdf->Cell(140, 10, ucfirst($solicitud['plazo']), 0, 1);

    // Salto de línea
    $pdf->Ln(10);

    // Títulos de la tabla de pagos (centrado)
    $pdf->SetX(50); // Alineación desde el borde izquierdo para centrar la tabla
    $pdf->Cell(50, 10, 'Fecha de Pago', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Monto Pago', 1, 1, 'C');

    // Información de los pagos (centrado)
    foreach ($pagos as $pago) {
        // Verificar si se necesita agregar una nueva página
        if ($pdf->GetY() > 260) { // Si la posición Y es mayor que 260mm, añadir nueva página
            $pdf->AddPage();
            addBackground($pdf);
            $pdf->SetY(40); // Ajustar la posición inicial después de la imagen en la nueva página
        }
        
        $pdf->SetX(50); // Centrar las celdas de la tabla
        $pdf->Cell(50, 10, $pago['fecha_pago'], 1, 0, 'C');
        $pdf->Cell(50, 10, '$' . number_format($pago['monto_pago'], 2), 1, 1, 'C');
    }

    // Salida del PDF
    $pdf->Output();
} else {
    echo "No se ha recibido el ID de la solicitud.";
    exit;
}
?>
