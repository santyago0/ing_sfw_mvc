<?php
class Clase {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function obtenerClases() {
        $sql = "SELECT * FROM Clase ORDER BY fechaHora ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearClase($nombre, $descripcion, $fechaHora, $cupoMaximo) {
        $sql = "INSERT INTO Clase (nombre, descripcion, fechaHora, cupoMaximo, cupoDisponible) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $fechaHora, $cupoMaximo, $cupoMaximo]);
    }

    public function eliminarClase($idClase) {
        $sql = "DELETE FROM Clase WHERE idClase = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idClase]);
    }

    public function actualizarClase($idClase, $nombre, $descripcion, $fechaHora, $cupoMaximo) {
        $sql = "UPDATE Clase SET nombre = ?, descripcion = ?, fechaHora = ?, cupoMaximo = ?, cupoDisponible = ? WHERE idClase = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombre, $descripcion, $fechaHora, $cupoMaximo, $cupoMaximo, $idClase]);
    }
}
?>
