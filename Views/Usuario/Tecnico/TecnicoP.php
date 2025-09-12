<?php
<<<<<<< HEAD
/*   
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != ROL_TECNICO) {
    header("Location: index.php?accion=redireccion");
    exit();
}
    require_once ("./Views/include/TH.php");*/
session_start();
require_once("Config/conexion.php");

if (!isset($_SESSION['rol'])) {
    header("Location: index.php?accion=login");
    exit();
}

if ($_SESSION['rol'] != ROL_TECNICO) {
    echo "<h1>Acceso denegado: no tienes permisos de técnico.</h1>";
    echo "<p><a href='index.php?accion=redireccion'>Volver</a></p>";
    exit();
}

// Incluir vista segura
require_once("./Views/include/TH.php");
=======
    
    if (isset($_SESSION['rol']) == ROL_TECNICO) {
    } elseif (isset($_SESSION['rol']) == ROL_CLIENTE){
        header("Location: index.php?accion=redireccion");
    } else {
        header("Location: index.php?accion=login");
    }
require_once ("./Views/include/InicioH.php");
    require_once ("./Views/include/TH.php");
    
>>>>>>> parent of 6b4e793 (Merge branch 'main' into Test)
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Técnico</title>
<<<<<<< HEAD
    <link rel="stylesheet" href="./Assets/css/inicio.css">
</head>

=======
    <link rel="stylesheet" href="./Assets/css/Usuarios.css"> </head>
>>>>>>> parent of 6b4e793 (Merge branch 'main' into Test)
<body>
    <main>
        <p>Aquí podrás gestionar tus tareas como técnico.</p>
    </main>
<<<<<<< HEAD
    <div class="btn-container">
        <a href="Index.php?accion=SolicitudesLibres"><button class="btn btn-boton">Solicitudes Disponibles</button></a>
        <a href="Index.php?accion=SolicitudesOcupadas"><button class="btn btn-boton">Tus Trabajos Pendientes</button></a><br>
    </div>
=======
    <a href="Index.php?accion=SolicitudesLibres">Solicitudes disponibles</a>
    <a href="Index.php?accion=SolicitudesOcupadas">Tus trabajos pendientes</a>

    <a href="Index.php?accion=logout">cerrar sesion</a>
>>>>>>> parent of 6b4e793 (Merge branch 'main' into Test)
</body>

</html>