<?php
class Usuarios {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function buscarPorCedula($cedula) {
        $sql = "SELECT * FROM ingreso WHERE cedula = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$cedula]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crearUsuario($cedula, $usuario, $contrasena) {
        $sql = "INSERT INTO credencialesGuardadas (cedula, usuario, contrasena) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$cedula, $usuario, $contrasena]);
    }

    public function obtenerCredenciales() {
        $sql = "SELECT cedula, usuario, contrasena FROM credencialesGuardadas";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>