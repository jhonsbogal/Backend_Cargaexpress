<?php
include_once '../modelos/conexion.php';
include_once '../modelos/inventario.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conexión a la base de datos usando PDO
try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$bd", $usuario, $clave);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Error de conexión: ' . $e->getMessage()]);
    exit();
}

// Obtener método de solicitud
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $inventario = new inventario($pdo);
        $result = $inventario->obtenerTodos();
        echo json_encode(['resultado' => 'OK', 'movimientos' => $result]);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id'])) {
            $inventario = new inventario($pdo);
            $result = $inventario->obtenerPorId($data['id']);
            echo json_encode(['resultado' => 'OK', 'movimiento' => $result]);
        } else {
            $inventario = new inventario($pdo);
            $result = $inventario->guardar($data);
            echo json_encode(['resultado' => 'OK', 'mensaje' => 'Movimiento registrado']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'] ?? null;
        
        if ($id) {
            $inventario = new inventario($pdo);
            $result = $inventario->actualizar($id, $data['producto'], $data['cantidad'], $data['tipoMovimiento']);
            echo json_encode(['resultado' => 'OK', 'mensaje' => 'Movimiento actualizado']);
        } else {
            echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'ID no proporcionado']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'] ?? null;
        
        if ($id) {
            $inventario = new inventario($pdo);
            $result = $inventario->eliminar($id);
            echo json_encode(['resultado' => 'OK', 'mensaje' => 'Movimiento eliminado']);
        } else {
            echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'ID no proporcionado']);
        }
        break;

    default:
        echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Método no soportado']);
        break;
}
?>
