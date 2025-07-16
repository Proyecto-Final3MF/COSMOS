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

                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required> <br>

                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required> <br>

                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>


        <?php include('../includes/footer.php'); ?>
    </section>
</body>
</html>

