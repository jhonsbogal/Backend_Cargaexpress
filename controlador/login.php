<?php
include_once '../modelos/conexion.php'; 
include_once '../modelos/login.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$usuario = $_GET['usuario'];
$contrasena = $_GET['contrasena'];

$login = new login($conexion);

$vec = $login->consulta($usuario, $contrasena);


$datosj = json_encode($vec);
echo $datosj;
?>
