<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>
    <h2>Registro de Paciente</h2>
    <form method="POST" action="controlador/controlador_registro.php">
        <label>Nombre:</label><input type="text" name="nombre" required><br>
        <label>Email:</label><input type="email" name="email" required><br>
        <label>Contraseña:</label><input type="password" name="password" required><br>
        <input type="submit" value="Registrarse">
    </form>
</body>
</html>
