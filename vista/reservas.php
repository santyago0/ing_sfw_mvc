<?php
require_once '../modelo/database.php';
require_once '../modelo/clase.php';
require_once '../modelo/reserva.php';
include 'header.php';

$db = (new Database())->connect();
$claseModel = new Clase($db);
$reservaModel = new Reserva($db);

$clases = $claseModel->obtenerClases();
$reservas = $db->query("SELECT Reserva.idReserva, Clase.nombre AS nombreClase, Clase.fechaHora
                        FROM Reserva
                        JOIN Clase ON Reserva.idClase = Clase.idClase
                        ORDER BY Clase.fechaHora ASC")
                ->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Reservar Clase</h1>

<?php if (isset($_GET['mensaje'])): ?>
    <p style="color: green;"><?php echo htmlspecialchars($_GET['mensaje']); ?></p>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha y Hora</th>
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
            <td><?php echo $clase['cupoDisponible']; ?></td>
            <td>
                <?php if ($clase['cupoDisponible'] > 0): ?>
                    <form method="POST" action="../controlador/reservaControlador.php" style="display: inline;">
                        <input type="hidden" name="accion" value="reservar">
                        <input type="hidden" name="idClase" value="<?php echo $clase['idClase']; ?>">
                        <input type="text" name="nombreSocio" placeholder="Tu nombre" required>
                        <button type="submit">Reservar</button>
                    </form>
                <?php else: ?>
                    <span>Sin cupo</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Mis Reservas</h2>
<table>
    <thead>
        <tr>
            <th>Clase</th>
            <th>Fecha y Hora</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservas as $reserva): ?>
        <tr>
            <td><?php echo $reserva['nombreClase']; ?></td>
            <td><?php echo $reserva['fechaHora']; ?></td>
            <td>
                <a href="../controlador/reservaControlador.php?cancelar=1&idReserva=<?php echo $reserva['idReserva']; ?>" 
                   onclick="return confirm('¿Estás seguro de cancelar esta reserva?');">
                   Cancelar
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
