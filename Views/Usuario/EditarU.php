<?php
require_once ("./Views/include/UH.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="./Assets/css/Main.css">
    <style>
        #preview {
            display: block;
            margin-top: 10px;
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="contenedor-formulario">
    <section>
        <h3>Editar Usuario</h3>

        <form method="POST" action="Index.php?accion=actualizarU" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $datos['id'] ?>">
            <input type="hidden" name="foto_actual" value="<?= htmlspecialchars($datos['foto_perfil']) ?>">

            <p class="fade-label">Nombre:</p>
            <input type="text" name="nombre" value="<?= htmlspecialchars($datos['nombre']) ?>" required><br><br>

             <p class="fade-label"> Email: </p> <input type="mail" name="email" value="<?= $datos['email'] ?>"><br>

            <p class="fade-label">Foto de perfil (opcional)</p>
            <input type="file" name="foto_perfil" accept="image/*" id="foto_perfil"><br>

            <p class="fade-label">Vista previa:</p>
            <img id="preview" src="<?= htmlspecialchars($datos['foto_perfil']) ?>" alt="Foto de perfil">

            <br><br>
            <input type="submit" value="Guardar cambios">

        </form>
    </section>

    <div class="botones-container">
        <a href="index.php?accion=redireccion"><button class="btn btn-boton">Volver</button></a>
    </div>
</div>

<script>
    const inputFoto = document.getElementById('foto_perfil');
    const preview = document.getElementById('preview');

    inputFoto.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(file);
        } else {
            // Si no hay archivo seleccionado, volver a mostrar la foto actual
            preview.setAttribute('src', '<?= htmlspecialchars($datos['foto_perfil']) ?>');
        }
    });
</script>

<script src="Assets/js/trancicion.js"></script>
</body>
</html>
