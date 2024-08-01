<?php
class Cotizacion {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertar($data) {
        $origen = mysqli_real_escape_string($this->conexion, $data->origen);
        $destino = mysqli_real_escape_string($this->conexion, $data->destino);
        $distancia = mysqli_real_escape_string($this->conexion, $data->distancia);
        $peso = mysqli_real_escape_string($this->conexion, $data->peso);
        $tipoMercancia = mysqli_real_escape_string($this->conexion, $data->tipoMercancia);

        $sql = "INSERT INTO cotizacion (origen, destino, distancia, peso, tipoMercancia) 
                VALUES ('$origen', '$destino', '$distancia', '$peso', '$tipoMercancia')";

        if (mysqli_query($this->conexion, $sql)) {
            return ['resultado' => 'OK', 'mensaje' => 'Cotización guardada con éxito'];
        } else {
            return ['resultado' => 'ERROR', 'mensaje' => 'Error al guardar la cotización: ' . mysqli_error($this->conexion)];
        }
    }
}
?>
