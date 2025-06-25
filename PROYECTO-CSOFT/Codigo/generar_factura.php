<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    echo "No se especificó la reparación.";
    exit();
}

$id_reparacion = intval($_GET['id']);

// Consultar reparación con datos cliente
$sql = "SELECT r.id_reparacion, r.descripcion, r.costo, r.estado, r.fecha_reparacion,
               c.nombre, c.cedula
        FROM reparaciones r
        JOIN clientes c ON r.id_cliente = c.id_cliente
        WHERE r.id_reparacion = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id_reparacion]);
$reparacion = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reparacion) {
    echo "Reparación no encontrada.";
    exit();
}

// Manejar envío del formulario para generar factura
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insertar factura en BD
    $sqlInsert = "INSERT INTO facturas (id_reparacion, total) VALUES (:id_reparacion, :total)";
    $stmtInsert = $pdo->prepare($sqlInsert);
    $stmtInsert->execute([
        ':id_reparacion' => $id_reparacion,
        ':total' => $reparacion['costo']
    ]);
    $id_factura = $pdo->lastInsertId();

    echo "<p>Factura generada exitosamente. ID Factura: $id_factura</p>";
    echo '<a href="listar_reparaciones.php">Volver a lista</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Generar Factura</title>
    <link rel="stylesheet" href="css/estilos.css" />
</head>
<body>
    <div class="container">
        <h1>Generar Factura</h1>

        <h3>Datos de Reparación</h3>
        <p><strong>ID Reparación:</strong> <?php echo htmlspecialchars($reparacion['id_reparacion']); ?></p>
        <p><strong>Cliente:</strong> <?php echo htmlspecialchars($reparacion['nombre']); ?> (Cédula: <?php echo htmlspecialchars($reparacion['cedula']); ?>)</p>
        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($reparacion['descripcion']); ?></p>
        <p><strong>Costo:</strong> $<?php echo number_format($reparacion['costo'], 2); ?></p>
        <p><strong>Estado:</strong> <?php echo htmlspecialchars($reparacion['estado']); ?></p>
        <p><strong>Fecha Reparación:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($reparacion['fecha_reparacion']))); ?></p>

        <form method="post" action="">
            <button type="submit">Generar Factura</button>
        </form>

        <a href="listar_reparaciones.php">Volver a lista</a>
    </div>
</body>
</html>
