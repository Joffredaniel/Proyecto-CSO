<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "citas_medicas";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
