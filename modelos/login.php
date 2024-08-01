<?php
class login {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function consulta($usuario, $contrasena) {
        $con = "SELECT * FROM credencialesGuardadas WHERE usuario='$usuario' && contrasena='$contrasena'";
        $res = mysqli_query($this->conexion, $con);
        $vec=[];

        while($row = mysqli_fetch_array($res)){
            $vec[] = $row;
        }

        if($vec==[]){
            $vec[0] = array("validar"=>"no valida");
        }else{
            $vec[0]['validar']="valida";
        }

        return $vec;
    }
}
?>