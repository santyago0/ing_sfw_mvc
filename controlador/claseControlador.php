<?php
require_once '../modelo/database.php';
require_once '../modelo/clase.php';

$db = (new Database())->connect();
$claseModel = new Clase($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'crear') {
        // Crear una clase
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $fechaHora = $_POST['fechaHora'];
        $cupoMaximo = $_POST['cupoMaximo'];

        $claseModel->crearClase($nombre, $descripcion, $fechaHora, $cupoMaximo);
    } elseif (isset($_POST['accion']) && $_POST['accion'] === 'editar') {
        // Editar una clase
        $idClase = $_POST['idClase'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $fechaHora = $_POST['fechaHora'];
        $cupoMaximo = $_POST['cupoMaximo'];

        $claseModel->actualizarClase($idClase, $nombre, $descripcion, $fechaHora, $cupoMaximo);
    }
    header("Location: ../vista/clases.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['eliminar'])) {
    // Eliminar una clase
    $idClase = $_GET['idClase'];
    $claseModel->eliminarClase($idClase);

    header("Location: ../vista/clases.php");
    exit;
}
?>
