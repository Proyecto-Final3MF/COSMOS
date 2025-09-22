<?php
require_once ("./Views/include/UH.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="./Assets/css/Formulario.css">
</head>
<body>
<div class="contenedor-formulario">
<section>
    <h3>Nuevo Producto</h3>
    <form method="POST" action="Index.php?accion=guardarP" enctype="multipart/form-data">

        <p>Nombre del Equipo: </p>
        <label for="nombre" class="form-label"></label>
        <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" required> <br><br>

        <p>Imagen: </p>
        <input type="file" class="form-control" id="imagen" name="imagen" autocomplete="off" required>
        <label for="imagen" class="btn-boton3-input">Seleccionar Archivo</label>
        <br> <span id="nombre-archivo-seleccionado"></span>
        <br><br>
        <p>Categoria:</p>
            <select id="categoria" name="categoria" required>
                <option value=""></option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nombre']) ?></option>
                <?php endforeach; ?>
            </select> <br><br>     
        <button type="submit">Crear</button>
    </form>
</section>
</div>
<div class="botones-container">
        <a href="index.php?accion=listarP"><button class="btn btn-boton">Volver</button></a>
    </div>
<script src="Assets/js/imagenformulario.js"></script>
<script src="Assets/js/trancicion.js"></script>
</body>
</html>