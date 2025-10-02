<?php
if (isset($_SESSION['rol']) && in_array($_SESSION['rol'], [ROL_TECNICO, ROL_CLIENTE, ROL_ADMIN])) {
    header("Location: index.php?accion=redireccion");
} 

require_once ("./Views/include/UH.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
        <h3>Registrarse</h3>

        <form method="POST" action="index.php?accion=guardarU" enctype="multipart/form-data">

            <p class="fade-label">Usuario</p>
            <input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off" required> <br><br>

            <p class="fade-label">Email </p>
            <label for="mail" class="form-label"></label>
            <input type="mail" class="form-control" id="mail" name="mail" autocomplete="off" required> <br><br>
                        
            <p class="fade-label">Rol</p>
            <select id="rol" name="rol" required>
                <option value=""></option>
                <?php foreach ($roles as $rol): ?>
                    <option value="<?= $rol['id'] ?>"><?= htmlspecialchars($rol['nombre']) ?></option>
                <?php endforeach; ?>
            </select> <br><br>

            <p class="fade-label">Contraseña</p>
            <input type="password" class="form-control" id="contrasena" name="contrasena" required> <br><br>

            <p class="fade-label">Foto de perfil (opcional)</p>
            <input type="file" name="foto_perfil" accept="image/*" id="foto_perfil"> <br>
            <img id="preview" src="#" alt="Vista previa" style="display:none;"><br>

            <input class="button" type="submit" value="Guardar">
            <a href="Index.php?accion=login">¿Ya tiene una cuenta? Inicie sesión</a>

        </form>
    </section>
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
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });
</script>

<script src="Assets/js/trancicion.js"></script>
</body>
</html>
