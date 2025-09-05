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
    <link rel="stylesheet" href="./Assets/css/inicio.css"> </head>
<body>
    <main>
        <p>Aquí podrás gestionar tus tareas como técnico.</p>
    </main>
    <div class="btn-container">
    <a href="Index.php?accion=SolicitudesLibres"><button class="btn btn-boton">Solicitudes Disponibles</button></a>
    <a href="Index.php?accion=SolicitudesOcupadas"><button class="btn btn-boton">Tus Trabajos Pendientes</button></a><br>
    </div>
    <div class="iframe-container">
    <iframe src="Index.php?accion=SolicitudesLibres" width="30%" height="40%" frameborder="1"></iframe>
    <iframe src="Index.php?accion=SolicitudesOcupadas" width="30%" height="40%" frameborder="1"></iframe>
    </div>
</body>
</html>