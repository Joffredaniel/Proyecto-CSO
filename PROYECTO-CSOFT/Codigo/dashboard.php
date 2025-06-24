<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="css/estilos.css" />
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h1>
        <p><a href="logout.php">Cerrar sesión</a></p>
    </div>
</body>
</html>
