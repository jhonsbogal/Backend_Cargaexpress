<?php
class nuevocliente {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM nuevocliente";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM nuevocliente WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $apellidos, $email, $identificacion, $tipo_identificacion) {
        $sql = "UPDATE nuevocliente SET nombre = ?, apellidos = ?, email = ?, identificacion = ?, tipo_identificacion = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nombre, $apellidos, $email, $identificacion, $tipo_identificacion, $id]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM nuevocliente WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function guardar($data) {
        $sql = "INSERT INTO nuevocliente (nombre, apellidos, email, identificacion, tipo_identificacion) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['nombre'], $data['apellidos'], $data['email'], $data['identificacion'], $data['tipo_identificacion']]);
    }
}
?>
