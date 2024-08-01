<?php
// archivo: modelos/envio.php

class Envio {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM nuevo_envio";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM nuevo_envio WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre_envia, $nombre_recibe, $fecha_envio, $categoria) {
        $sql = "UPDATE nuevo_envio SET nombre_envia = ?, nombre_recibe = ?, fecha_envio = ?, categoria = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nombre_envia, $nombre_recibe, $fecha_envio, $categoria, $id]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM nuevo_envio WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
