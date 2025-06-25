<?php
include 'conexion.php';

// Consultar todas las facturas junto con datos de reparación y cliente
$sql = "SELECT f.id_factura, f.fecha_factura, f.total,
               r.id_reparacion, r.descripcion,
               c.nombre, c.cedula
        FROM facturas f
        JOIN reparaciones r ON f.id_reparacion = r.id_reparacion
        JOIN clientes c ON r.id_cliente = c.id_cliente
        ORDER BY f.fecha_factura DESC";

$stmt = $pdo->query($sql);
$facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Lista de Facturas</title>
    <link rel="stylesheet" href="css/estilos.css" />
</head>
<body>
    <div class="container">
        <h1>Lista de Facturas</h1>

        <?php if (count($facturas) === 0): ?>
            <p>No hay facturas registradas.</p>
        <?php else: ?>
            <table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color:#007BFF; color:white;">
                        <th>ID Factura</th>
                        <th>ID Reparación</th>
                        <th>Cliente</th>
                        <th>Cédula</th>
                        <th>Descripción</th>
                        <th>Fecha Factura</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($facturas as $factura): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($factura['id_factura']); ?></td>
                            <td><?php echo htmlspecialchars($factura['id_reparacion']); ?></td>
                            <td><?php echo htmlspecialchars($factura['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($factura['cedula']); ?></td>
                            <td><?php echo htmlspecialchars($factura['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($factura['fecha_factura']))); ?></td>
                            <td>$<?php echo number_format($factura['total'], 2); ?></td>
                            <td>
                                <a href="ver_factura.php?id=<?php echo $factura['id_factura']; ?>">Ver</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <a href="listar_reparaciones.php" style="display:block; margin-top:20px;">Volver a Reparaciones</a>
    </div>
</body>
</html>
