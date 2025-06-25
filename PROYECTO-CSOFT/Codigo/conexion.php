<?php
// Datos de conexión
$host = 'localhost';
$port = '5432'; // Puerto por defecto de PostgreSQL
$dbname = 'taller_reparacion';
$user = 'postgres'; // Cambia por tu usuario de PostgreSQL
$password = 'postgres'; // Cambia por tu contraseña

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    // Crear conexión PDO
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    //echo "Conexión exitosa a PostgreSQL";
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
    exit();
}
?>
