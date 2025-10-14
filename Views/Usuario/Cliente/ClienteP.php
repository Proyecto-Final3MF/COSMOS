<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != ROL_CLIENTE) {
    header("Location: index.php?accion=redireccion");
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
    <a href="index.php?accion=listarP">
        <button class="btn btn-boton444 btn-mis-productos">
            <i class="fa-solid fa-box"></i> Mis Productos
        </button>
    </a>
    <a href="index.php?accion=formularioS">
        <button class="btn btn-boton444 btn-crear">
            <i class="fa-solid fa-plus-circle"></i> Crear Nueva Solicitud
        </button>
    </a>
    <a href="index.php?accion=listarSLU">
        <button class="btn btn-boton444 btn-sin-asignar">
            <i class="fa-solid fa-hourglass-half"></i> Solicitudes Sin Asignar
        </button>
    </a>
    <a href="index.php?accion=listarSA">
        <button class="btn btn-boton444 btn-aceptadas">
            <i class="fa-solid fa-check"></i> Solicitudes Aceptadas
        </button>
    </a>
    <a href="index.php?accion=listarST">
        <button class="btn btn-boton444 btn-terminadas">
            <i class="fa-solid fa-flag-checkered"></i> Solicitudes Terminadas
        </button>
    </a>

</div>

</div>
<script src="Assets/js/trancicion.js"></script>
</body>
</html>