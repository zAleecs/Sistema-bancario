<?php
header('Content-Type: application/json');
include 'includes/conexion.php';

if (!isset($_GET['id'])) {
    echo json_encode(['puede_solicitar' => false, 'mensaje' => 'ID de cliente no proporcionado']);
    exit;
}

$cliente_id = intval($_GET['id']);
$response = [
    'puede_solicitar' => false,
    'mensaje' => ''
];

// Verificar si hay un préstamo activo
$sql = "SELECT id, monto_final, monto_pagado FROM solicitudes WHERE cliente_id = ? AND estado = 'activo' LIMIT 1";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['puede_solicitar' => false, 'mensaje' => 'Error en la consulta: ' . $conn->error]);
    exit;
}
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $response['puede_solicitar'] = true;
    $response['mensaje'] = "No tiene préstamos activos. Puede solicitar uno.";
} else {
    $solicitud = $result->fetch_assoc();
    $monto_final = $solicitud['monto_final'];
    $monto_pagado = $solicitud['monto_pagado'] ?? 0;
    $porcentaje = ($monto_pagado / $monto_final) * 100;

    if ($porcentaje >= 70) {
        $response['puede_solicitar'] = true;
        $response['mensaje'] = "Ha pagado el {$porcentaje}% del préstamo. Puede solicitar otro préstamo.";
    } else {
        $response['mensaje'] = "Solo ha pagado el {$porcentaje}% del préstamo. Debe pagar al menos el 70% para solicitar otro.";
    }
}

echo json_encode($response);
