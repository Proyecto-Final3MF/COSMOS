<?php
    
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: Index.php?accion=redireccion");
    exit();
}
    require_once ("./Views/include/UH.php");

$notifC = new NotificacionC();
$contador_normales = count($notifC->listarNoLeidas('normal'));

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Técnico</title>
    <link rel="stylesheet" href="./Assets/css/Main.css"> </head>
<body>
    <br>

    <h2 class="fade-slide">Aquí podrás gestionar tus tareas como técnico.</h2>


<div class="btn-container fade-slide">
    <a href="Index.php?accion=listarTL">
    <button class="btn btn-boton444">
        <i class="fa-solid fa-list btn-disponibles"></i> Solicitudes Disponibles
        <?php if ($contador_normales > 0): ?>
            <span class="contador" id="contador-normales"><?= $contador_normales ?></span>
        <?php endif; ?>
    </button>
</a>
    <a href="Index.php?accion=listarSA">
        <button class="btn btn-boton444">
            <i class="fa-solid fa-check-circle btn-aceptadas"></i> Solicitudes Aceptadas
        </button>
    </a>
    <a href="Index.php?accion=listarST">
        <button class="btn btn-boton444">
            <i class="fa-solid fa-flag-checkered btn-terminadas"></i> Solicitudes Terminadas
        </button>
    </a>
</div>
<script src="Assets/js/trancicion.js"></script>
</body>
</html>