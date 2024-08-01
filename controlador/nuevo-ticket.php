<?php
include_once '../modelos/conexion.php'; // Ruta actualizada
include_once '../modelos/nuevo-ticket.php'; // Ruta actualizada

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $control = $_GET['control'] ?? '';

    if ($control === 'insertar') {
        $data = json_decode(file_get_contents("php://input"));

        if ($data) {
            $nuevoTicket = new NuevoTicket($conexion);
            $result = $nuevoTicket->insertar($data);

            echo json_encode($result);
        } else {
            echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Datos no recibidos']);
        }
    } else {
        echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Control no válido']);
    }
} else {
    echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Método no permitido']);
}
?>
