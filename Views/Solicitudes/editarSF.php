<?php
require_once ("./Views/include/UH.php");
// Defensivo: evitar errores si $datosSolicitud no existe
if (!isset($datosSolicitud) || $datosSolicitud === null) {
    $datosSolicitud = [
        'id' => '',
        'titulo' => '',
        'descripcion' => '',
        'estado_id' => ''
    ];
}

// Defensivo: evitar errores si $estados no existe
if (!isset($estados) || $estados === null) {
    $estados = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Solicitud</title>
    <link rel="stylesheet" href="./Assets/css/Main.css">
</head>
<body>

<div class="btn-volver-container fade-slide">
    <button class="btn-volver" id="btnVolver">
    <i class="fa fa-arrow-left"></i> Volver
</button>
</div>

<div class="contenedor-formulario">
<section>
    <h3>Editar Solicitud</h3>
    <form method="POST" action="index.php?accion=actualizarSF">
        <input type="hidden" name="id" value="<?= htmlspecialchars($datosSolicitud['id']) ?>">

        <p class="fade-label">Título:</p>
        <input type="text" class="form-control" name="titulo" value="<?= htmlspecialchars($datosSolicitud['titulo']) ?>" disabled>

        <p class="fade-label">Descripción:</p>
        <textarea class="form-control" name="descripcion" rows="5" required><?= htmlspecialchars($datosSolicitud['descripcion']) ?></textarea><br><br>

        <p class="fade-label">Estado:</p>
        <select name="estado" required>
            <?php foreach ($estados as $estado): ?>
                <option value="<?= htmlspecialchars($estado['id']) ?>" 
                <?= ($estado['id'] == $datosSolicitud['estado_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($estado['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Actualizar Solicitud</button>
    </form>
</section>
<br>
</div>
<script src="Assets/js/trancicion.js"></script>
</body>
</html>