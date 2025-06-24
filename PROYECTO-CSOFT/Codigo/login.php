<?php
session_start();
include 'conexion.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario'] ?? '');
    $clave = $_POST['clave'] ?? '';

    if (empty($usuario) || empty($clave)) {
        $error = "Por favor, ingrese usuario y contraseña.";
    } else {
        try {
            $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':usuario' => $usuario]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($clave, $user['clave'])) {
                $_SESSION['usuario'] = $usuario;
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos.";
            }
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            $error = "Error al procesar la solicitud. Intente nuevamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login administrador</title>
    <link rel="stylesheet" href="css/estilos.css" />
</head>
<body>
    <div class="container">
        <h1>Login administrador</h1>

        <?php if ($error): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" action="login.php">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required />

            <label for="clave">Contraseña:</label>
            <input type="password" id="clave" name="clave" required />

            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>
