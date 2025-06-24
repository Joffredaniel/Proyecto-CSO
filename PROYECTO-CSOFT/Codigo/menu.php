<?php
session_start();
?>

<nav style="background-color:#007BFF; padding:10px;">
    <div style="max-width: 900px; margin: auto; display: flex; justify-content: space-between; align-items: center; color: white; font-weight: bold;">
        <div>
            <a href="dashboard.php" style="color:white; text-decoration:none; margin-right:20px;">Inicio</a>
            <a href="registro_cliente.php" style="color:white; text-decoration:none; margin-right:20px;">Registrar Cliente</a>
            <a href="registro_reparacion.php" style="color:white; text-decoration:none;">Registrar Reparación</a>
        </div>
        <div>
            <?php if (isset($_SESSION['usuario'])): ?>
                Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?> |
                <a href="logout.php" style="color:white; text-decoration:none; margin-left:10px;">Cerrar sesión</a>
            <?php else: ?>
                <a href="login.php" style="color:white; text-decoration:none;">Ingresar</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
