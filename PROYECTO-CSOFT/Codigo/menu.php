<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="css/estilos.css"> <!-- si tienes uno -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            padding: 40px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        .menu {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-top: 30px;
        }

        .menu a {
            display: block;
            width: 250px;
            padding: 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        .menu a:hover {
            background-color: #0056b3;
        }

        .cerrar-sesion {
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>

    <div class="menu">
        <a href="registro_cliente.php">Registrar Cliente</a>
        <a href="registro_reparacion.php">Registrar Reparación</a>
        <a href="listar_reparaciones.php">Gestionar Reparaciones</a>
        <a href="listar_facturas.php">Facturas</a>

    </div>

    <div class="cerrar-sesion">
        <a href="logout.php" style="color: red;">Cerrar Sesión</a>
    </div>

</body>
</html>
