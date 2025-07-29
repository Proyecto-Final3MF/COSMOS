<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="">
</head>

<body>
    <section>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <h3>Iniciar Sesion</h3>
        <form method="POST" action="Index.php?accion=autenticar">

            <p>Usuario: </p>
            <label for="usuario" class="form-label"></label>
            <input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off" required> <br><br>

            <p>Contraseña: </p>
            <label for="contrasena" class="form-label"></label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" autocomplete="off" required> <br><br>
                        
            <button type="submit">Entrar</button>
            <a href="index.php?accion=register">¿No tiene una cuenta? Registrese</a>
        </form>

    </section>
</body>
</html>
