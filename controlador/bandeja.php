<?php
// archivo: bandeja.php
include_once '../modelos/conexion.php'; // Ruta actualizada
include_once '../modelos/bandeja.php'; // Ruta actualizada

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

try {
    switch ($method) {
        case 'GET':
            // Obtener todos los registros
            $sql = "SELECT * FROM nuevo_ticket";
            $stmt = $pdo->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['resultado' => 'OK', 'tickets' => $result]);
            break;

        case 'POST':
            // Crear un nuevo registro o buscar uno específico
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $data['id'] ?? null;
            
            if ($id) {
                $sql = "SELECT * FROM nuevo_ticket WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode(['resultado' => 'OK', 'bandeja' => $result]);
            } else {
                echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'ID no proporcionado']);
            }
            break;

        case 'DELETE':
            // Eliminar un registro
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $data['id'] ?? null;

            if ($id) {
                $sql = "DELETE FROM nuevo_ticket WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
                echo json_encode(['resultado' => 'OK', 'mensaje' => 'Registro eliminado']);
            } else {
                echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'ID no proporcionado']);
            }
            break;

        default:
            echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Método no soportado']);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Error: ' . $e->getMessage()]);
}
?>
