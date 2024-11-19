<?php
require_once '../modelo/database.php';
require_once '../modelo/reserva.php';

$db = (new Database())->connect();
$reservaModel = new Reserva($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'reservar') {
        // Crear una reserva
        $idClase = $_POST['idClase'];
        $nombreSocio = $_POST['nombreSocio'];

        $reservaCreada = $reservaModel->crearReserva($idClase, $nombreSocio);

        if ($reservaCreada) {
            $mensaje = "Reserva creada con éxito.";
        } else {
            $mensaje = "No hay cupos disponibles para esta clase.";
        }

        header("Location: ../vista/reservas.php?mensaje=" . urlencode($mensaje));
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cancelar'])) {
    // Cancelar una reserva
    $idReserva = $_GET['idReserva'];

    $reservaCancelada = $reservaModel->cancelarReserva($idReserva);

    $mensaje = $reservaCancelada
        ? "La reserva ha sido cancelada exitosamente."
        : "Ocurrió un error al intentar cancelar la reserva.";

    header("Location: ../vista/reservas.php?mensaje=" . urlencode($mensaje));
    exit;
}

?>
