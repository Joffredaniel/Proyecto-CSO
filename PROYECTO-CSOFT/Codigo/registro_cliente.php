<?php
include 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = trim($_POST['cedula']);
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);

    // Validaciones básicas
    if (empty($cedula) || empty($nombre)) {
        $mensaje = "La cédula y el nombre son obligatorios.";
    } elseif (!preg_match('/^\d{6,10}$/', $cedula)) {
        // Ejemplo simple: cédula sólo números entre 6 y 10 dígitos
        $mensaje = "Cédula inválida.";
    } elseif (!empty($correo) && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Correo inválido.";
    } else {
        // Intentamos registrar en BD con transacción
        try {
            $pdo->beginTransaction();

            $sql = "INSERT INTO clientes (cedula, nombre, telefono, correo) 
                    VALUES (:cedula, :nombre, :telefono, :correo)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':cedula' => $cedula,
                ':nombre' => $nombre,
                ':telefono' => $telefono,
                ':correo' => $correo
            ]);

            $pdo->commit();

            $mensaje = "Cliente registrado con éxito.";
        } catch (PDOException $e) {
            $pdo->rollBack();

            // Guardamos el error en el log del servidor (archivo error_log)
            error_log("Error BD registro cliente: " . $e->getMessage());

            // Mostrar mensaje genérico al usuario
            if ($e->getCode() == 23505) { // Código PG para violación de clave única
                $mensaje = "Error: La cédula ya está registrada.";
            } else {
                $mensaje = "Error al registrar cliente. Intente nuevamente.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrar Cliente</title>
    <link rel="stylesheet" href="css/estilos.css" />
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <h1>Registrar Cliente</h1>

        <?php if ($mensaje != ""): ?>
            <div class="message <?php echo (strpos($mensaje, 'Error') === 0) ? 'error' : 'success'; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <form action="registro_cliente.php" method="post">
            <label for="cedula">Cédula:</label>
            <input type="text" name="cedula" id="cedula" maxlength="10" required />

            <label for="nombre">Nombre completo:</label>
            <input type="text" name="nombre" id="nombre" required />

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" />

            <label for="correo">Correo electrónico:</label>
            <input type="email" name="correo" id="correo" />

            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>
