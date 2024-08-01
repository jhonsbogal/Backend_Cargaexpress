<?php
class ingreso {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM ingreso";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM ingreso WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $empleado) {
        $sql = "UPDATE ingreso SET nombre = ?, apellido = ?, cedula = ?, telefono = ?, sede = ?, puesto = ?, salario = ?, fechaAfiliacion = ?, registroEPS = ?, registroARL = ?, registroPension = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $empleado['nombre'],
            $empleado['apellido'],
            $empleado['cedula'],
            $empleado['telefono'],
            $empleado['sede'],
            $empleado['puesto'],
            $empleado['salario'],
            $empleado['fechaAfiliacion'],
            $empleado['registroEPS'],
            $empleado['registroARL'],
            $empleado['registroPension'],
            $id
        ]);
    }

    public function guardar($empleado) {
        $sql = "INSERT INTO ingreso (nombre, apellido, cedula, telefono, sede, puesto, salario, fechaAfiliacion, registroEPS, registroARL, registroPension) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $empleado['nombre'],
            $empleado['apellido'],
            $empleado['cedula'],
            $empleado['telefono'],
            $empleado['sede'],
            $empleado['puesto'],
            $empleado['salario'],
            $empleado['fechaAfiliacion'],
            $empleado['registroEPS'],
            $empleado['registroARL'],
            $empleado['registroPension']
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM ingreso WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>

