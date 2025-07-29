<?php

    if (isset($_SESSION['rol']) == ROL_TECNICO) {
    } elseif (isset($_SESSION['rol']) == ROL_CLIENTE){
        header("Location: index.php?accion=panel");
    } else {
        header("Location: index.php?accion=login");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Técnico</title>
    <link rel="stylesheet" href="../../css.css"> </head>
<body>
    <header>
        <h1>Bienvenido, Técnico <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
    </header>
    
    <main>
        <p>Aquí podrás gestionar tus tareas como técnico.</p>
    </main>

    <a href="../../../Index.php?accion=loguot">cerrar sesion</a>
</body>
</html>