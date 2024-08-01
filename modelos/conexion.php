<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$bd = "cargaexpress";

// Crear conexión
$conexion = mysqli_connect($servidor, $usuario, $clave);

// Verificar conexión
if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}

// Seleccionar base de datos
if (!mysqli_select_db($conexion, $bd)) {
    die("Error al seleccionar la base de datos: " . mysqli_error($conexion));
}

// Establecer el conjunto de caracteres
if (!mysqli_set_charset($conexion, "utf8")) {
    die("Error al establecer el conjunto de caracteres: " . mysqli_error($conexion));
}
?>
