<?php
if (isset($_SESSION['rol']) && in_array($_SESSION['rol'], [1, 2, 3])) {
    header("Location: index.php?accion=redireccion");
} 

require_once ("./Views/include/UH.php");
?>

    <title>Registro</title>

<div class="contenedor-formulario">
    <section class="formularios99">
        <h3>Registrarse</h3>

        <form method="POST" action="index.php?accion=guardarU" enctype="multipart/form-data">

            <p class="fade-label">Nombre de Usuario</p>
            <input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off" placeholder="sin caracteres especiales" required> <br><br>

            <p class="fade-label">Email </p>
            <label for="mail" class="form-label"></label>
            <input type="email" pattern="^[\p{L}0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" class="form-control" id="mail" name="mail" autocomplete="off" required> <br><br>
            
            <p class="fade-label">Contraseña</p>
            <div class="password-container">
            <input type="password" class="form-control" id="contrasena" name="contrasena" minlength="8" placeholder="mínimo 8 caracteres" required>
            <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('contrasena', this)"></i>
            </div>
            <br>

            <p class="fade-label">Confirmar Contraseña</p>
            <div class="password-container">
            <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" minlength="8" required>
            <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('confirmar_contrasena', this)"></i>
            </div>
            <p id="error-password" class="error-text"></p>
            <br>

            <input class="button" type="submit" value="Guardar">
            <a href="Index.php?accion=login" class="login9" >¿Ya tiene una cuenta? Inicie sesión</a>

        </form>
    </section>
    <br>
</div>
<script src="Assets/js/imagenformulario.js"></script>
<script src="Assets/js/vercontrasena.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>