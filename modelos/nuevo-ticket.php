<?php
class NuevoTicket {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertar($data) {
        $tipo_problema = mysqli_real_escape_string($this->conexion, $data->tipo_problema);
        $usuario_nombre = mysqli_real_escape_string($this->conexion, $data->usuario_nombre);
        $area_reporta = mysqli_real_escape_string($this->conexion, $data->area_reporta);
        $observaciones = mysqli_real_escape_string($this->conexion, $data->observaciones);
        $fecha = mysqli_real_escape_string($this->conexion, $data->fecha);
        
        $sql = "INSERT INTO nuevo_ticket (tipo_problema, usuario_nombre, area_reporta, observaciones, fecha) 
                VALUES ('$tipo_problema', '$usuario_nombre', '$area_reporta', '$observaciones', '$fecha')";

        if (mysqli_query($this->conexion, $sql)) {
            $id = mysqli_insert_id($this->conexion); // Obtener el ID insertado
            return ['resultado' => 'OK', 'mensaje' => 'Registro guardado con éxito', 'id' => $id];
        } else {
            return ['resultado' => 'ERROR', 'mensaje' => 'Error al guardar el registro: ' . mysqli_error($this->conexion)];
        }
    }
}
?>
