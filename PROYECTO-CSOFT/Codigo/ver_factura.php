<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    echo "No se especificó la factura.";
    exit();
}

$id_factura = intval($_GET['id']);

// Consultar datos de factura, reparación y cliente
$sql = "SELECT f.id_factura, f.fecha_factura, f.total,
               r.descripcion, r.estado, r.fecha_reparacion,
               c.nombre, c.cedula
        FROM facturas f
        JOIN reparaciones r ON f.id_reparacion = r.id_reparacion
        JOIN clientes c ON r.id_cliente = c.id_cliente
        WHERE f.id_factura = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id_factura]);
$factura = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$factura) {
    echo "Factura no encontrada.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Factura #<?php echo htmlspecialchars($factura['id_factura']); ?></title>
    <link rel="stylesheet" href="css/estilos.css" />
</head>
<body>
    <div class="container">
        <h1>Factura #<?php echo htmlspecialchars($factura['id_factura']); ?></h1>

        <p><strong>Fecha:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($factura['fecha_factura']))); ?></p>

        <h3>Cliente</h3>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($factura['nombre']); ?></p>
        <p><strong>Cédula:</strong> <?php echo htmlspecialchars($factura['cedula']); ?></p>

        <h3>Detalles de Reparación</h3>
        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($factura['descripcion']); ?></p>
        <p><strong>Estado:</strong> <?php echo htmlspecialchars($factura['estado']); ?></p>
        <p><strong>Fecha Reparación:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($factura['fecha_reparacion']))); ?></p>

        <h3>Total a Pagar</h3>
        <p><strong>$<?php echo number_format($factura['total'], 2); ?></strong></p>

        <a href="listar_reparaciones.php">Volver a lista</a>
    </div>
</body>
</html>
