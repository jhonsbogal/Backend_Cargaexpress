<?php
class NuevoEnvio {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function insertar($data) {
        $nombre_envia = mysqli_real_escape_string($this->conexion, $data->nombre_envia);
        $tipo_id_envia = mysqli_real_escape_string($this->conexion, $data->tipo_id_envia);
        $num_id_envia = mysqli_real_escape_string($this->conexion, $data->num_id_envia);
        $telefono_envia = mysqli_real_escape_string($this->conexion, $data->telefono_envia);
        $direccion_envia = mysqli_real_escape_string($this->conexion, $data->direccion_envia);
        $nombre_recibe = mysqli_real_escape_string($this->conexion, $data->nombre_recibe);
        $tipo_id_recibe = mysqli_real_escape_string($this->conexion, $data->tipo_id_recibe);
        $num_id_recibe = mysqli_real_escape_string($this->conexion, $data->num_id_recibe);
        $telefono_recibe = mysqli_real_escape_string($this->conexion, $data->telefono_recibe);
        $direccion_recibe = mysqli_real_escape_string($this->conexion, $data->direccion_recibe);
        $categoria = mysqli_real_escape_string($this->conexion, $data->categoria);

        $sql = "INSERT INTO nuevo_envio (nombre_envia, tipo_id_envia, num_id_envia, telefono_envia, direccion_envia, nombre_recibe, tipo_id_recibe, num_id_recibe, telefono_recibe, direccion_recibe, categoria) 
                VALUES ('$nombre_envia', '$tipo_id_envia', '$num_id_envia', '$telefono_envia', '$direccion_envia', '$nombre_recibe', '$tipo_id_recibe', '$num_id_recibe', '$telefono_recibe', '$direccion_recibe', '$categoria')";

        if (mysqli_query($this->conexion, $sql)) {
            $id = mysqli_insert_id($this->conexion); // Obtener el ID insertado
            return ['resultado' => 'OK', 'mensaje' => 'Registro guardado con éxito', 'id' => $id];
        } else {
            return ['resultado' => 'ERROR', 'mensaje' => 'Error al guardar el registro: ' . mysqli_error($this->conexion)];
        }
    }
}
?>
