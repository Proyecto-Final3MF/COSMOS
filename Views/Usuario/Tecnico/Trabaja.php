<?php
    include_once("./Views/include/UH.php");
?>
<br>

<h1 class="fade-label">Bienvenido</h1>
<p class="fade-label">para trabajar con nosotros porfavor envianos tu email para poder entrar en contacto</p>

<div class="contenedor-formulario">
    <section class="formularios999">
        <form method="POST" action="Index.php?accion=mail">
            <p class="fade-label">Correo electrónico</p>
            <input type="email" class="form-control" id="usuario" name="usuario" autocomplete="off" required>

            <button class="button" type="submit">Enviar</button>
        </form>
    </section>
</div>