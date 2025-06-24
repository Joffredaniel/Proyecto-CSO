<?php
include 'conexion.php';

$estadoFiltro = $_GET['estado'] ?? '';

// Construir la consulta SQL con filtro si se selecciona un estado
if ($estadoFiltro && in_array($estadoFiltro, ['En proceso', 'Completada', 'Cancelada'])) {
    $sql = "SELECT r.id_reparacion, c.nombre, c.cedula, r.descripcion, r.costo, r.estado, r.fecha_reparacion
            FROM reparaciones r
            JOIN clientes c ON r.id_cliente = c.id_cliente
            WHERE r.estado = :estado
            ORDER BY r.fecha_reparacion DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':estado' => $estadoFiltro]);
} else {
    $sql = "SELECT r.id_reparacion, c.nombre, c.cedula, r.descripcion, r.costo, r.estado, r.fecha_reparacion
            FROM reparaciones r
            JOIN clientes c ON r.id_cliente = c.id_cliente
            ORDER BY r.fecha_reparacion DESC";
    $stmt = $pdo->query($sql);
}

$reparaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Lista de Reparaciones</title>
    <link rel="stylesheet" href="css/estilos.css" />
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <h1>Lista de Reparaciones</h1>

        <form method="get" action="listar_reparaciones.php">
            <label for="estado">Filtrar por estado:</label>
            <select name="estado" id="estado" onchange="this.form.submit()">
                <option value="">-- Todos --</option>
                <option value="En proceso" <?php if ($estadoFiltro == 'En proceso') echo 'selected'; ?>>En proceso</option>
                <option value="Completada" <?php if ($estadoFiltro == 'Completada') echo 'selected'; ?>>Completada</option>
                <option value="Cancelada" <?php if ($estadoFiltro == 'Cancelada') echo 'selected'; ?>>Cancelada</option>
            </select>
        </form>

        <table border="1" cellpadding="8" cellspacing="0" style="width:100%; margin-top:20px; border-collapse: collapse;">
            <thead>
                <tr style="background-color:#007BFF; color:white;">
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Cédula</th>
                    <th>Descripción</th>
                    <th>Costo</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($reparaciones) === 0): ?>
                    <tr><td colspan="7" style="text-align:center;">No hay reparaciones.</td></tr>
                <?php else: ?>
                    <?php foreach ($reparaciones as $rep): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($rep['id_reparacion']); ?></td>
                            <td><?php echo htmlspecialchars($rep['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($rep['cedula']); ?></td>
                            <td><?php echo htmlspecialchars($rep['descripcion']); ?></td>
                            <td>$<?php echo number_format($rep['costo'], 2); ?></td>
                            <td><?php echo htmlspecialchars($rep['estado']); ?></td>
                            <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($rep['fecha_reparacion']))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
