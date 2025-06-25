<?php
include 'conexion.php'; // Incluye la conexión PDO y crea $conn

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos enviados desde el formulario para actualizar
    $id = intval($_POST['id_reparacion']);
    $descripcion = $_POST['descripcion'];
    $costo = floatval($_POST['costo']);
    $estado = $_POST['estado'];

    $sql = "UPDATE reparaciones 
            SET descripcion = :descripcion, costo = :costo, estado = :estado 
            WHERE id_reparacion = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':descripcion' => $descripcion,
        ':costo' => $costo,
        ':estado' => $estado,
        ':id' => $id
    ]);

    // Redirigir a la lista después de guardar cambios
    header("Location: listar_reparaciones.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "No se especificó ID de reparación.";
    exit();
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM reparaciones WHERE id_reparacion = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$reparacion = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reparacion) {
    echo "Reparación no encontrada.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8" />
    <title>Editar Reparación</title>
    <link rel="stylesheet" href="css/estilos.css" />


</head>
<body>
    <h1>Editar Reparación #<?php echo htmlspecialchars($reparacion['id_reparacion']); ?></h1>

    <form method="post" action="editar_reparacion.php">
        <input type="hidden" name="id_reparacion" value="<?php echo htmlspecialchars($reparacion['id_reparacion']); ?>" />

        <label>Descripción:</label><br />
        <textarea name="descripcion" required><?php echo htmlspecialchars($reparacion['descripcion']); ?></textarea><br />

        <label>Costo:</label><br />
        <input type="number" step="0.01" name="costo" value="<?php echo htmlspecialchars($reparacion['costo']); ?>" required /><br />

        <label>Estado:</label><br />
        <select name="estado" required>
            <option value="En proceso" <?php if ($reparacion['estado'] === 'En proceso') echo 'selected'; ?>>En proceso</option>
            <option value="Completada" <?php if ($reparacion['estado'] === 'Completada') echo 'selected'; ?>>Completada</option>
            <option value="Cancelada" <?php if ($reparacion['estado'] === 'Cancelada') echo 'selected'; ?>>Cancelada</option>
        </select><br /><br />

        <button type="submit">Guardar cambios</button>
    </form>

    <a href="listar_reparaciones.php">Volver a la lista</a>
</body>
</html>
