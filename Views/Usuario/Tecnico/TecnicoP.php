<?php

    if (isset($_SESSION['rol']) == ROL_TECNICO) {
    } elseif (isset($_SESSION['rol']) == ROL_CLIENTE){
        header("Location: index.php?accion=panel");
    } else {
        header("Location: index.php?accion=login");
    }

    require_once ("./Views/includes/TH.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Técnico</title>
    <link rel="stylesheet" href="../../css.css"> </head>
<body>
    <main>
        <p>Aquí podrás gestionar tus tareas como técnico.</p>
    </main>

    <a href="Index.php?accion=logout">cerrar sesion</a>
</body>
</html>