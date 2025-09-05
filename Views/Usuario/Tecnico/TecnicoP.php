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
    <a href="Index.php?accion=SolicitudesLibres"><button class="btn btn-boton">Solicitudes Disponibles</button></a>
    <a href="Index.php?accion=SolicitudesOcupadas"><button class="btn btn-boton">Tus Trabajos Pendientes</button></a><br>
    <iframe src="Index.php?accion=SolicitudesLibres" width="40%" height="45%" frameborder="1"></iframe>
    <iframe src="Index.php?accion=SolicitudesOcupadas" width="40%" height="45%" frameborder="1"></iframe>
</body>
</html>