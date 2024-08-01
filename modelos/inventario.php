<?php
class inventario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM inventario";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM inventario WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function guardar($data) {
        $sql = "INSERT INTO inventario (producto, cantidad, tipoMovimiento) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['producto'], $data['cantidad'], $data['tipoMovimiento']]);
    }

    public function actualizar($id, $producto, $cantidad, $tipoMovimiento) {
        $sql = "UPDATE inventario SET producto = ?, cantidad = ?, tipoMovimiento = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$producto, $cantidad, $tipoMovimiento, $id]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM inventario WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
