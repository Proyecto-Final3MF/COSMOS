<link rel="icon" type="image/png" href="Assets/imagenes/logonueva.png">

<?php
    require_once("Views/include/UH.php");

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<br>

<h1 class="inicio55">
    <?php if (isset($_SESSION['usuario'])): ?>
        Más Sobre Nosotros, <span style="color: #e83e8c; font-weight: bold;">
            <?= htmlspecialchars($_SESSION['usuario']) ?>.
        </span>
    <?php else: ?>
        Sobre Nosotros
    <?php endif; ?>
</h1>

<p class="inicio44">
    COSMOS es un Servicio Web desarrollado por la empresa Técnicos y Asociados.
</p>