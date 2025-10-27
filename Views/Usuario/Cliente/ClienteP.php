<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != ROL_CLIENTE) {
    header("Location: Index.php?accion=redireccion");
    exit();
}  

require_once ("./Views/include/UH.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Panel de Cliente</title>
     <link rel="stylesheet" href="./Assets/css/Main.css"></head>
</head>
<body>
    <br>
<div>

<div class="btn-container fade-slide">
<a href="Index.php?accion=urgenteP">
        <button class="btn btn-boton4445 btn-crearU">
            <i class="fa-solid fa-plus-circle"></i>Nueva Solicitud Urgente
        </button>
    </a>
</div>

    <h2 class="fade-slide">¿En qué podemos ayudarte?</h2>
    
    <div class="btn-container fade-slide">
    <a href="Index.php?accion=listarP">
        <button class="btn btn-boton444">
            <i class="fa-solid fa-box btn-mis-productos"></i> Mis Productos
        </button>
    </a>

    <a href="Index.php?accion=formularioS">
        <button class="btn btn-boton444">
            <i class="fa-solid fa-plus-circle btn-crear"></i> Crear Nueva Solicitud
        </button>
    </a>

    <a href="Index.php?accion=listarSLU">
        <button class="btn btn-boton444">
            <i class="fa-solid fa-hourglass-half btn-sin-asignar"></i> Solicitudes Recien Creadas
        </button>
    </a>

    <a href="Index.php?accion=listarSA">
        <button class="btn btn-boton444">
            <i class="fa-solid fa-check btn-aceptadas"></i> Solicitudes que aceptaron
        </button>
    </a>

    <a href="Index.php?accion=listarST">
        <button class="btn btn-boton444">
            <i class="fa-solid fa-flag-checkered btn-terminadas"></i> Solicitudes Terminadas
        </button>
    </a>

</div>

</div>
<script src="Assets/js/trancicion.js"></script>
</body>
</html>