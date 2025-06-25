<?php
include 'conexion.php';  // Incluye conexión PDO

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitiza el id como entero

    $sql = "DELETE FROM reparaciones WHERE id_reparacion = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    header("Location: listar_reparaciones.php");
    exit();
} else {
    echo "No se recibió el ID de reparación para eliminar.";
}
?>
