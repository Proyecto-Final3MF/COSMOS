<link rel="icon" type="image/png" href="Assets/imagenes/logonueva.png">

<?php
    require_once("Views/include/UH.php");

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<br>

<h1 class="inicio55 reveal">
    <?php if (isset($_SESSION['usuario'])): ?>
        Más Sobre Nosotros, <span style="color: #e83e8c; font-weight: bold;">
            <?= htmlspecialchars($_SESSION['usuario']) ?>.
        </span>
    <?php else: ?>
        Sobre Nosotros
    <?php endif; ?>
</h1>

<p class="inicio44 reveal">
    Les presento COSMOS, una plataforma web creada para conectar de forma 
    rápida, segura y eficiente a clientes con técnicos informáticos calificados. 
    En pocas palabras: si se te rompe un dispositivo y necesitás ayuda urgente, 
    COSMOS es tu mejor aliado.
</p>

<br><br>

<h2 class="nosotros reveal">
    Cómo Nació
</h2>

<p class="nosotro reveal">
    Todos hemos pasado por ese momento en que nuestra computadora, celular o 
    tablet deja de funcionar justo cuando más la necesitamos, ¿verdad? 
    Y lo peor es que no sabemos a quién acudir, los servicios tardan, o simplemente 
    no encontramos un técnico confiable. 
    En Rivera detectamos justamente ese problema: la falta de comunicación 
    rápida y organizada entre clientes y técnicos. 
    Y ahí fue donde nació COSMOS, una solución pensada para crear una red de 
    comunicación directa, confiable y accesible.
</p>

<br>

<h2 class="nosotros reveal">
    Desarrolladores
</h2>

<p class="nosotros reveal">
    La aplicacion COSMOS fue desarrolada por:
</p>

<section class="equipo-container">
    <div class="miembro reveal">
        <img src="Assets/imagenes/perfil/elfede.jpeg" alt="Miembro 1">
        <h3>Federico Mosegui</h3>
    </div>

    <div class="miembro reveal">
        <img src="Assets/imagenes/perfil/elthiago.jpeg" alt="Miembro 2">
        <h3>Thiago Carballo</h3>
    </div>

    <div class="miembro reveal">
        <img src="Assets/imagenes/perfil/yoese.jpeg" alt="Miembro 3">
        <h3>Alex Gonzalez</h3>
    </div>

    <div class="miembro reveal">
        <img src="Assets/imagenes/perfil/fotodefault.webp" alt="Miembro 4">
        <h3>Sergio Lopez</h3>
    </div>

    <div class="miembro reveal">
        <img src="Assets/imagenes/perfil/fotodefault.webp" alt="Miembro 5">
        <h3>Lucas Vargas</h3>
    </div>

    <div class="miembro reveal">
        <img src="Assets/imagenes/perfil/fotodefault.webp" alt="Miembro 6">
        <h3>Franco Fagundez</h3>
    </div>
</section>
<script src="Assets/js/aparicion.js"></script>