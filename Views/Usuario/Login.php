<?php

    if (isset($_SESSION['rol']) == ROL_TECNICO or isset($_SESSION['rol']) == ROL_CLIENTE){
        header("Location: index.php?accion=redireccion");
    } 

require_once ("./Views/include/UH.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./Assets/css/Main.css">
</head>

<body>
    <div class="contenedor-formulario">
    <section class="formularios99">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <h3>Iniciar Sesion</h3>
        <form method="POST" action="Index.php?accion=autenticar">

            <p class="fade-label">Usuario </p>
            <label for="usuario" class="form-label"></label>
            <input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off" required> <br><br>

            <p class="fade-label">Contraseña </p>
            <label for="contrasena" class="form-label"></label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" autocomplete="off" required> <br><br>
                        
            <button class="button" type="submit">Entrar</button>
            <a href="index.php?accion=register" class="login9" >¿No tiene una cuenta? Registrese</a>
        </form>
    </section>
    <br>
    </div>
    <script src="Assets/js/trancicion.js"></script>
</body>
</html>