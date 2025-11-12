<?php
if (!isset($_SESSION['usuario'])) {
    header("Location: Index.php?accion=login");
    exit();
}
require_once(__DIR__ . "../../include/UH.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Eliminación de Usuario</title>
    <link rel="stylesheet" href="./Assets/css/Main.css">
</head>
<body>
    <br>
    <h1 class="inicio55">Confirmar Eliminación de Cuenta</h1>

    <div class="btn-volver-container fade-slide">
        <button class="btn-volver" id="btnVolver">
            <i class="fa fa-arrow-left"></i> Volver
        </button>
    </div>

    <div class="alert alert-warning">
        <h2>¿Estás seguro de que quieres eliminar esta cuenta?</h2>
        <br>
        <p><strong>Usuario:</strong> <?= htmlspecialchars($usuario['nombre']) ?> (<?= htmlspecialchars($usuario['email']) ?>)</p>
        <?php if (!$dependencias['puede_eliminar']): ?>
            <p class="text-danger"><strong>Advertencia:</strong> <?= $dependencias['mensaje'] ?></p>
            <p>No se puede eliminar hasta resolver las dependencias.</p>
        <?php else: ?>
            <p>Esta acción es irreversible y eliminará todos los datos asociados (mensajes, notificaciones, etc.).</p>
        <?php endif; ?>
    </div>

    <?php if ($dependencias['puede_eliminar']): ?>
        <form action="Index.php?accion=eliminarU&id=<?= $usuario['id'] ?>" method="POST">
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Confirmas la eliminación?')">Eliminar Cuenta</button>
        </form>
    <?php endif; ?>

    <script src="Assets/js/botonvolver.js"></script>
    <script src="Assets/js/trancicion.js"></script>
</body>
</html>