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
        <?php include('../includes/header.php'); ?>
                <h3>Iniciar Sesión</h3>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="POST" action="SesionI.php?accion=autenticar">

                        <p>Usuario: </p>
                        <label for="usuario" class="form-label"></label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required> <br><br>

                        <p>Email: </p>
                        <label for="mail" class="form-label"></label>
                        <input type="mail" class="form-control" id="mail" name="mail" required> <br><br>
                        
                        <p>Rol:</p>
                        <label for="rol" class="form-label"></label>
                        <input type="text" class="form-control" id="rol" name="rol" required> <br><br>
                        
                        <p>Contraseña: </p>
                        <label for="contrasena" class="form-label"></label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" required> <br><br>


                    <button type="submit" class="btn btn-primary w-100">Entrar</button><br><br>
                    <a href="./register.php">¿No tiene cuenta? Registrese</a>
                </form>

        <?php include('../includes/footer.php'); ?>
    </section>
</body>
</html>
