<?php
session_start();
require_once("modelo/conexion.php");

if ($_SESSION['rol'] !== 'admin') {
    echo "Acceso denegado";
    exit();
}

if (isset($_GET['cancelar'])) {
    $id_cita = $_GET['cancelar'];
    $conn->query("UPDATE citas SET estado='cancelada' WHERE id='$id_cita'");
}

$sql = "SELECT c.id, u.nombre, c.fecha, c.hora, c.estado FROM citas c JOIN usuarios u ON c.id_usuario = u.id";
$result = $conn->query($sql);

echo "<h2>Panel de Administración - Citas</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>Paciente</th><th>Fecha</th><th>Hora</th><th>Estado</th><th>Acción</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['nombre']}</td><td>{$row['fecha']}</td><td>{$row['hora']}</td><td>{$row['estado']}</td>";
        if ($row['estado'] != 'cancelada') {
            echo "<td><a href='?cancelar={$row['id']}'>Cancelar</a></td>";
        } else {
            echo "<td>Cancelada</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay citas registradas.";
}
?>
