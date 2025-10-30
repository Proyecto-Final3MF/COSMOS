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

    <h2 class="fade-slide">¿En qué podemos ayudarte?</h2>

    <div class="btn-container fade-slide">
    <a href="Index.php?accion=urgenteP">
        <button class="btn btn-boton4445 btn-crearU">
            <i class="fa-solid fa-plus-circle"></i>
            <span class="title">Nueva Solicitud Urgente</span>
        </button>
    </a>
    </div>
    
    <div class="btn-container fade-slide">
    <a href="Index.php?accion=listarP">
        <button class="btn btn-boton444">
            <i class="fa-solid fa-box btn-mis-productos"></i> 
            <span class="title">Mis Productos</span>
            <span class="desc">Consulta tus Productos Hecho o Crea uno Nuevo.</span>
        </button>
    </a>

    <a href="Index.php?accion=formularioS">
        <button class="btn btn-boton444">
            <i class="fa-solid fa-plus-circle btn-crear"></i> 
            <span class="title">Crear Nueva Solicitud</span>
            <span class="desc">Crea Una Nueva Solicitud Asociando un Producto</span>
        </button>
    </a>

    <a href="Index.php?accion=listarSLU">
        <button class="btn btn-boton444">
            <i class="fa-solid fa-hourglass-half btn-sin-asignar"></i> 
            <span class="title">Solicitudes Creadas</span>
            <span class="desc">Consulta Tus Solicitudes ya Creadas en Espera de un Tecnico</span>
        </button>
    </a>

    <a href="Index.php?accion=listarSA">
        <button class="btn btn-boton444">
            <i class="fa-solid fa-check btn-aceptadas"></i> 
            <span class="title">Solicitudes que Aceptaron</span>
            <span class="desc">Consulta Tus Solicitudes Aceptadas Por el Tecnico y su Estado Actual</span>
        </button>
    </a>

    <a href="Index.php?accion=listarST">
        <button class="btn btn-boton444">
            <i class="fa-solid fa-flag-checkered btn-terminadas"></i> 
            <span class="title">Solicitudes Terminadas</span>
            <span class="desc">Consulta tus Ya Terminadas y Puntua el trabajo del Tecnico</span>
        </button>
    </a>

</div>

</div>
<script src="Assets/js/trancicion.js"></script>
</body>
</html>