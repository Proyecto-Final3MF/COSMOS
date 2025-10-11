<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != ROL_ADMIN) {
    header("Location: index.php?accion=redireccion");
    exit();
}

require_once ("./Views/include/UH.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Admin</title>
    <link rel="stylesheet" href="./Assets/css/Main.css"> </head>
<body>
    <br>
    <main>
        
    <h2 class="fade-slide">Aquí podrás gestionar tus tareas como Admin.</h2>
</main>

<div class="btn-container fade-slide">
    <a href="index.php?accion=FormularioC">
        <button class="btn btn-boton444 btn-crear">
            <i class="fa-solid fa-plus-circle"></i> Crear Nueva Categoría
        </button>
    </a>
    <a href="index.php?accion=listarC">
        <button class="btn btn-boton444 btn-listar">
            <i class="fa-solid fa-list"></i> Todas Las Categorías
        </button>
    </a>
    <a href="index.php?accion=mostrarHistorial">
        <button class="btn btn-boton444 btn-historial">
            <i class="fa-solid fa-clock-rotate-left"></i> Historial de Actividades
        </button>
    </a>
    <a href="index.php?accion=listarU">
        <button class="btn btn-boton444 btn-usuarios">
            <i class="fa-solid fa-users"></i> Lista de Usuarios
        </button>
    </a>
</div>

<script src="Assets/js/trancicion.js"></script>
</body>
</html>