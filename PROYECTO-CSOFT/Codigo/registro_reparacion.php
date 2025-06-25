<?php
include 'conexion.php';

$mensaje = "";

try {
    $stmtClientes = $pdo->query("SELECT id_cliente, cedula, nombre FROM clientes ORDER BY nombre");
    $clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener clientes: " . $e->getMessage());
    $mensaje = "Error al cargar los clientes. Intente nuevamente.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST['id_cliente'] ?? '';
    $descripcion = trim($_POST['descripcion'] ?? '');
    $costo = $_POST['costo'] ?? '';
    $estado = 'En proceso';

    // Validación básica
    if (empty($id_cliente) || empty($descripcion) || $costo === '') {
        $mensaje = "Por favor, completa todos los campos obligatorios.";
    } elseif (!is_numeric($costo) || $costo < 0) {
        $mensaje = "El costo debe ser un número positivo.";
    } else {
        try {
            $pdo->beginTransaction();

            $sql = "INSERT INTO reparaciones (id_cliente, descripcion, costo, estado) 
                    VALUES (:id_cliente, :descripcion, :costo, :estado)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_cliente' => $id_cliente,
                ':descripcion' => $descripcion,
                ':costo' => $costo,
                ':estado' => $estado
            ]);

            $pdo->commit();

            $mensaje = "Reparación registrada con éxito.";
        } catch (PDOException $e) {
            $pdo->rollBack();

            error_log("Error al registrar reparación: " . $e->getMessage());

            $mensaje = "Error al registrar reparación. Intente nuevamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrar Reparación</title>
    <link rel="stylesheet" href="css/estilos.css" />
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <h1>Registrar Reparación</h1>

        <?php if ($mensaje != ""): ?>
            <div class="message <?php echo (strpos($mensaje, 'Error') === 0) ? 'error' : 'success'; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <form action="registro_reparacion.php" method="post">
            <label for="id_cliente">Cliente:</label>
            <select name="id_cliente" id="id_cliente" required>
                <option value="">Seleccione un cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['id_cliente']; ?>">
                        <?php echo htmlspecialchars($cliente['nombre'] . " (" . $cliente['cedula'] . ")"); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="descripcion">Descripción de la reparación:</label>
            <textarea name="descripcion" id="descripcion" rows="4" required></textarea>

            <label for="costo">Costo estimado:</label>
            <input type="number" step="0.01" name="costo" id="costo" min="0" required />

            <button type="submit">Registrar Reparación</button>
        </form>
    </div>
</body>
</html>
