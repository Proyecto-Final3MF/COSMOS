<?php
if (!isset($_SESSION['rol']) == ROL_TECNICO) {
    header("Location: index.php?accion=redireccion");
}

require_once ("./Views/include/AH.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Admin</title>
    <link rel="stylesheet" href="./Assets/css/inicio.css"> </head>
<body>
    <main>
        <p>Aquí podrás gestionar tus tareas como Admin.</p>
    </main>
<a href="index.php?accion=FormularioC"><button class="btn btn-boton">Crear Nueva Categoria</button></a>
<a href="index.php?accion=listarC"><button class="btn btn-boton">Todas Las Categorias</button></a>
<a href="Index.php?accion=logout"><button class="btn btn-boton">Cerrar Sesion</button></a>
</body>
</html>