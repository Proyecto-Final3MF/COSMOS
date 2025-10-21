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
</head>
<body>
<div class="contenedor-formulario">
    <section class="formularios99">
        <h3>Registrarse</h3>

        <form method="POST" action="index.php?accion=guardarU" enctype="multipart/form-data">

            <p class="fade-label">Foto de perfil (opcional)</p>
            <img id="preview" src="Assets/imagenes/perfil/fotodefault.webp" alt="" class="foto-perfil">

            <div class="input-archivo">
            <input type="file" name="foto_perfil" accept="image/*" id="foto_perfil" hidden>
            <label for="foto_perfil" class="btn-boton3-input">Seleccionar Foto</label>
            <span class="nombre-archivo-seleccionado">Ningúna Foto seleccionada</span>
            </div>
            <br>

            <p class="fade-label">Usuario</p>
            <input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off" placeholder="sin caracteres especiales" required> <br><br>

            <p class="fade-label">Email </p>
            <label for="mail" class="form-label"></label>
            <input type="email" class="form-control" id="mail" name="mail" autocomplete="off" required> <br><br>
                        
             <p class="fade-label">¿Eres Un?</p>

            <div class="rol-container">
            <?php foreach ($roles as $rol): ?>
            <div class="rol-option" data-value="<?= $rol['id'] ?>">
            <?= htmlspecialchars($rol['nombre']) ?>
            </div>
            <?php endforeach; ?>
            </div>
            <input type="hidden" id="rol" name="rol" required>  
            
            <br><br>
            
            <p class="fade-label">Contraseña</p>
            <input type="password" class="form-control" id="contrasena" name="contrasena" minlength="8" placeholder="minimo 8 caracteres" required> <br><br>

            <input class="button" type="submit" value="Guardar">
            <a href="Index.php?accion=login" class="login9" >¿Ya tiene una cuenta? Inicie sesión</a>

        </form>
    </section>
    <br>
</div>
<script src="Assets/js/botonrol.js"></script>
<script src="Assets/js/fotoperfilregistro.js"></script>
<script src="Assets/js/imagenformulario.js"></script>
<script src="Assets/js/trancicion.js"></script>
</body>
</html>