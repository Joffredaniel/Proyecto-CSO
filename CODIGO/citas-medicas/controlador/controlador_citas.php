<?php
session_start();
require_once("../modelo/conexion.php");

$id_usuario = $_SESSION['user_id'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];

// Verificar si ya hay cita en esa fecha y hora
$sql_check = "SELECT * FROM citas WHERE fecha = '$fecha' AND hora = '$hora'";
$result = $conn->query($sql_check);
if ($result->num_rows > 0) {
    echo "La cita ya está ocupada. Intente con otra hora.";
    exit();
}

// Insertar nueva cita
$sql = "INSERT INTO citas (id_usuario, fecha, hora) VALUES ('$id_usuario', '$fecha', '$hora')";
if ($conn->query($sql) === TRUE) {
    header("Location: ../ver_citas.php");
} else {
    echo "Error al reservar cita: " . $conn->error;
}
$conn->close();
?>
