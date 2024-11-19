<?php
class Reserva {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function crearReserva($idClase, $nombreSocio) {
        // Verificar si hay cupos disponibles
        $sqlCupo = "SELECT cupoDisponible FROM Clase WHERE idClase = ?";
        $stmtCupo = $this->db->prepare($sqlCupo);
        $stmtCupo->execute([$idClase]);
        $cupo = $stmtCupo->fetchColumn();

        if ($cupo > 0) {
            // Crear la reserva
            $sql = "INSERT INTO Reserva (idClase, nombreSocio) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $reservaCreada = $stmt->execute([$idClase, $nombreSocio]);

            // Actualizar el cupo disponible
            if ($reservaCreada) {
                $sqlActualizarCupo = "UPDATE Clase SET cupoDisponible = cupoDisponible - 1 WHERE idClase = ?";
                $stmtActualizar = $this->db->prepare($sqlActualizarCupo);
                $stmtActualizar->execute([$idClase]);
            }
            return $reservaCreada;
        } else {
            return false; // Sin cupo disponible
        }
    }

    public function cancelarReserva($idReserva) {
        // Obtener el ID de la clase asociada
        $sqlClase = "SELECT idClase FROM Reserva WHERE idReserva = ?";
        $stmtClase = $this->db->prepare($sqlClase);
        $stmtClase->execute([$idReserva]);
        $idClase = $stmtClase->fetchColumn();
    
        // Eliminar la reserva
        $sql = "DELETE FROM Reserva WHERE idReserva = ?";
        $stmt = $this->db->prepare($sql);
        $reservaCancelada = $stmt->execute([$idReserva]);
    
        // Liberar un cupo si se canceló la reserva
        if ($reservaCancelada) {
            $sqlLiberarCupo = "UPDATE Clase SET cupoDisponible = cupoDisponible + 1 WHERE idClase = ?";
            $stmtLiberar = $this->db->prepare($sqlLiberarCupo);
            $stmtLiberar->execute([$idClase]);
        }
        return $reservaCancelada;
    }    

    public function obtenerReservasPorClase($idClase) {
        $sql = "SELECT * FROM Reserva WHERE idClase = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idClase]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
