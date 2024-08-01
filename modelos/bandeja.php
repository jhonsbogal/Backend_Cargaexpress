<?php
class Bandeja {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM nuevo_ticket";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $tipo_problema, $usuario_nombre, $area_reporta, $observaciones) {
        $sql = "UPDATE nuevo_ticket SET tipo_problema = ?, usuario_nombre = ?, area_reporta = ?, observaciones = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$tipo_problema, $usuario_nombre, $area_reporta, $observaciones, $id]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM nuevo_ticket WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
