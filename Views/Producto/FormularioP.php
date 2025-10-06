<?php
require_once ("./Views/include/UH.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
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
    <h3>Nuevo Producto</h3>
    <form method="POST" action="Index.php?accion=guardarP" enctype="multipart/form-data">

        <p class="fade-label">Nombre del Equipo: </p>
        <label for="nombre" class="form-label"></label>
        <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" required> <br><br>

        <p class="fade-label">Imagen: </p>
        <div id="vista-previa-contenedor" style="margin-top: 15px;">
        <img id="vista-previa" src="./Assets/imagenes/sincargas4.png" alt="Vista previa" style="max-width:150px; max-height:150px; display:center;">
    </div>
        <div class="input-archivo">
        <input type="file" class="form-control" id="imagen" name="imagen" autocomplete="off" required hidden>
        <label for="imagen" class="btn-boton3-input">Seleccionar Archivo</label>
        <span id="nombre-archivo-seleccionado">Ningún archivo seleccionado</span>
    </div>
        <br><br>
        <p class="fade-label">Categoria:</p>
            <select id="categoria" name="categoria" required>
                <option value=""></option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nombre']) ?></option>
                <?php endforeach; ?>
            </select> <br><br>     
        <button type="submit">Crear</button>
    </form>
</section>
<br>
</div>
<script src="Assets/js/vistapreviafoto.js"></script>
<script src="Assets/js/imagenformulario.js"></script>
<script src="Assets/js/trancicion.js"></script>
</body>
</html>