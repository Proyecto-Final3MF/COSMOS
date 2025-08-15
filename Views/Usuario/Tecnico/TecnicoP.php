<?php
    if (isset($_SESSION['rol']) == ROL_TECNICO) {
    } elseif (isset($_SESSION['rol']) == ROL_CLIENTE){
        header("Location: index.php?accion=redireccion");
    } else {
        header("Location: index.php?accion=login");
    }

    require_once ("./Views/include/TH.php");
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Técnico</title>
    <link rel="stylesheet" href="./Assets/css/Usuarios.css"> </head>
<body>
    <main>
        <p>Aquí podrás gestionar tus tareas como técnico.</p>
    </main>
    <a href="Index.php?accion=SolicitudesLibres">Solicitudes disponibles</a>
    <a href="Index.php?accion=SolicitudesOcupadas">Tus trabajos pendientes</a>

    <a href="Index.php?accion=logout">cerrar sesion</a>
</body>
</html>