<?php
include_once '../modelos/conexion.php'; // Ruta actualizada a tu archivo de conexión

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Obtener los datos del POST
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['origen'], $data['destino'], $data['distancia'], $data['peso'], $data['tipoMercancia'])) {
    $origen = $data['origen'];
    $destino = $data['destino'];
    $distancia = $data['distancia'];
    $peso = $data['peso'];
    $tipoMercancia = $data['tipoMercancia'];

    // Crear conexión
    $conexion = mysqli_connect("localhost", "root", "", "cargaexpress");
    if (!$conexion) {
        echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Error en la conexión a la base de datos']);
        exit();
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO cotizacion (origen, destino, distancia, peso, tipoMercancia) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conexion, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssdds", $origen, $destino, $distancia, $peso, $tipoMercancia);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['resultado' => 'OK', 'mensaje' => 'Cotización guardada con éxito']);
        } else {
            echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Error al guardar la cotización: ' . mysqli_error($conexion)]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Error al preparar la consulta']);
    }

    mysqli_close($conexion);
} else {
    echo json_encode(['resultado' => 'ERROR', 'mensaje' => 'Datos incompletos']);
}
?>
