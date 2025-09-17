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
    <link rel="stylesheet" href="./Assets/css/inicio.css"> </head>
<body>
    <main>
        <p>Aquí podrás gestionar tus tareas como Admin.</p>
    </main>
<div class="btn-container">
<a href="index.php?accion=FormularioC"><button class="btn btn-boton">Crear Nueva Categoria</button></a>
<a href="index.php?accion=listarC"><button class="btn btn-boton">Todas Las Categorias</button></a>
<a href="index.php?accion=mostrarHistorial"><button class="btn btn-boton">Historial de actividades</button></a>
</div>
</body>
</html>