<?php
session_start();
require_once("modelo/conexion.php");

$id_usuario = $_SESSION['user_id'];
$rol = $_SESSION['rol'];

$sql = "SELECT * FROM citas WHERE id_usuario = '$id_usuario'";
$result = $conn->query($sql);

echo "<h2>Mis Citas</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>Fecha</th><th>Hora</th><th>Estado</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['fecha']}</td><td>{$row['hora']}</td><td>{$row['estado']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "No tienes citas agendadas.";
}
if ($rol === 'admin') {
    echo "<p><a href='admin_panel.php'>Ir al panel de administrador</a></p>";
}
?>
