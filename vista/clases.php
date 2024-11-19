<?php
require_once '../modelo/database.php';
require_once '../modelo/clase.php';
include 'header.php';

$db = (new Database())->connect();
$claseModel = new Clase($db);
$clases = $claseModel->obtenerClases();
?>

<h1>Gestión de Clases</h1>

<h2>Crear Clase</h2>
<form method="POST" action="../controller/ClaseController.php">
    <input type="hidden" name="accion" value="crear">
    <input type="text" name="nombre" placeholder="Nombre de la clase" required>
    <textarea name="descripcion" placeholder="Descripción"></textarea>
    <input type="datetime-local" name="fechaHora" required>
    <input type="number" name="cupoMaximo" placeholder="Cupo máximo" required>
    <button type="submit">Crear Clase</button>
</form>

<h2>Clases Disponibles</h2>
<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha y Hora</th>
            <th>Cupo Máximo</th>
            <th>Cupo Disponible</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clases as $clase): ?>
        <tr>
            <td><?php echo $clase['nombre']; ?></td>
            <td><?php echo $clase['descripcion']; ?></td>
            <td><?php echo $clase['fechaHora']; ?></td>
            <td><?php echo $clase['cupoMaximo']; ?></td>
            <td><?php echo $clase['cupoDisponible']; ?></td>
            <td>
                <a href="editar_clase.php?idClase=<?php echo $clase['idClase']; ?>">Editar</a>
                <a href="../controlador/claseControlador.php?eliminar=1&idClase=<?php echo $clase['idClase']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta clase?');">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
