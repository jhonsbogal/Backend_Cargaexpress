<?php
include_once '../modelos/conexion.php';
include_once '../modelos/nuevocliente.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$bd", $usuario, $clave);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Error de conexión: ' . $e->getMessage()]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $cliente = new nuevocliente($pdo);
        $result = $cliente->obtenerTodos();
        echo json_encode(['resultado' => 'OK', 'clientes' => $result]);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id'])) {
            $cliente = new nuevocliente($pdo);
            $result = $cliente->obtenerPorId($data['id']);
            echo json_encode(['resultado' => 'OK', 'cliente' => $result]);
        } else {
            $cliente = new nuevocliente($pdo);
            $result = $cliente->guardar($data);
            echo json_encode(['resultado' => 'OK', 'mensaje' => 'Registro guardado']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'] ?? null;

        if ($id) {
            $cliente = new nuevocliente($pdo);
            $result = $cliente->actualizar($id, $data['nombre'], $data['apellidos'], $data['email'], $data['identificacion'], $data['tipo_identificacion']);
            echo json_encode(['resultado' => 'OK', 'mensaje' => 'Registro actualizado']);
        } else {
            echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'ID no proporcionado']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'] ?? null;

        if ($id) {
            $cliente = new nuevocliente($pdo);
            $result = $cliente->eliminar($id);
            echo json_encode(['resultado' => 'OK', 'mensaje' => 'Registro eliminado']);
        } else {
            echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'ID no proporcionado']);
        }
        break;

    default:
        echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Método no soportado']);
        break;
}
