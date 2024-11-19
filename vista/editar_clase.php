<?php
require_once '../modelo/database.php';
require_once '../modelo/clase.php';
include 'header.php';

$db = (new Database())->connect();
$claseModel = new Clase($db);

$idClase = $_GET['idClase'];
$clase = $db->query("SELECT * FROM Clase WHERE idClase = $idClase")->fetch(PDO::FETCH_ASSOC);
?>

<h1>Editar Clase</h1>
<form method="POST" action="../controlador/claseControlador.php">
    <input type="hidden" name="accion" value="editar">
    <input type="hidden" name="idClase" value="<?php echo $clase['idClase']; ?>">
    <input type="text" name="nombre" placeholder="Nombre de la clase" value="<?php echo $clase['nombre']; ?>" required>
    <textarea name="descripcion" placeholder="Descripción"><?php echo $clase['descripcion']; ?></textarea>
    <input type="datetime-local" name="fechaHora" value="<?php echo $clase['fechaHora']; ?>" required>
    <input type="number" name="cupoMaximo" placeholder="Cupo máximo" value="<?php echo $clase['cupoMaximo']; ?>" required>
    <button type="submit">Guardar Cambios</button>
</form>
