<?php
    if (isset($_SESSION['rol']) == ROL_CLIENTE) {
    } elseif (isset($_SESSION['rol']) == ROL_TECNICO){
        header("Location: index.php?accion=redireccion");
    } else {
        header("Location: index.php?accion=login");
    }

    require_once ("./Views/include/CH.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href=""> </head>
<body>
    <p> cliente </p>
    <a href="Index.php?accion=formularioP">Crear Nuevo Producto</a><br>
    <a href="Index.php?accion=formularioS">Crear Nueva Solicitud</a><br>
    <a href="Index.php?accion=logout">cerrar sesion</a>
</body>
</html>