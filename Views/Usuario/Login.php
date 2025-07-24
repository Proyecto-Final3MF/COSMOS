<?php
    require_once("../../Config/conexion.php");
    $rol=mysqli_query($conexion, "SELECT * from rol");
?>


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
        <form method="POST" action="index.php?accion=autenticar">

            <p>Usuario: </p>
            <label for="usuario" class="form-label"></label>
            <input type="text" class="form-control" id="usuario" name="usuario" required> <br><br>

            <p>Email: </p>
            <label for="mail" class="form-label"></label>
            <input type="mail" class="form-control" id="mail" name="mail" required> <br><br>
                        
            <p>Rol:</p>
            <select name="categoria_id"><?php while($Rol = mysqli_fetch_assoc($rol)) {?>
            <option value="<?php echo $Rol['id']; ?>"> <?php echo $Rol['nombre'];?></option>
            <?php } ?>    
            <br><br>
                        
            <p>Contraseña: </p>
            <label for="contrasena" class="form-label"></label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" required> <br><br>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
            <a href="./Register.php">¿No tiene una cuenta? Registrese</a>
        </form>

    </section>
</body>
</html>
