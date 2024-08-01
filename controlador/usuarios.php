<?php
include_once '../modelos/conexion.php';
include_once '../modelos/usuarios.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
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
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($action === 'create') {
            if (isset($data['cedula']) && isset($data['usuario']) && isset($data['contrasena'])) {
                // Verificar si la cédula existe en la base de datos
                $usuarios = new Usuarios($pdo);
                $empleado = $usuarios->buscarPorCedula($data['cedula']);

                if ($empleado) {
                    // Crear usuario si la cédula está registrada
                    $result = $usuarios->crearUsuario($data['cedula'], $data['usuario'], $data['contrasena']);
                    echo json_encode(['resultado' => 'OK', 'mensaje' => 'Usuario creado correctamente']);
                } else {
                    // La cédula no está registrada
                    echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'La cédula no está registrada en la base de datos.']);
                }
            } else {
                echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Datos incompletos']);
            }
        } else {
            if (isset($data['cedula'])) {
                $empleado = new Usuarios($pdo);
                $result = $empleado->buscarPorCedula($data['cedula']);
                echo json_encode(['resultado' => 'OK', 'empleado' => $result]);
            } else {
                echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Cédula no proporcionada']);
            }
        }
        break;

    case 'GET':
        if ($action === 'getCredenciales') {
            $usuarios = new Usuarios($pdo);
            $credenciales = $usuarios->obtenerCredenciales();
            echo json_encode(['resultado' => 'OK', 'credenciales' => $credenciales]);
        } else {
            echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Acción no soportada']);
        }
        break;

    default:
        echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Método no soportado']);
        break;
}
?>
