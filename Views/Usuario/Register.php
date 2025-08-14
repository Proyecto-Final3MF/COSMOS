<?php
<<<<<<< Updated upstream

    if (isset($_SESSION['rol']) == ROL_TECNICO or isset($_SESSION['rol']) == ROL_CLIENTE){
=======
    if (isset($_SESSION['rol']) == ROL_TECNICO || isset($_SESSION['rol']) == ROL_CLIENTE || isset($_SESSION['rol']) == ROL_ADMIN){
>>>>>>> Stashed changes
        header("Location: index.php?accion=redireccion");
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
     <link rel="stylesheet" href="./Assets/css/register.css">
</head>
<body>
    
    <form method="POST" action="index.php?accion=guardarU">

        <h3>Registrarse</h3>


    <form method="POST" action="index.php?accion=guardarU">
        <p>Usuario </p>
        <label for="usuario" class="form-label"></label>
        <input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off" required> <br><br>

        <p>Email </p>
        <label for="mail" class="form-label"></label>
        <input type="mail" class="form-control" id="mail" name="mail" autocomplete="off" required> <br><br>
                        
        <p>Rol</p>
        <select id="rol" name="rol" required>
                <option value=""></option>
                <?php foreach ($roles as $rol): ?>
                    <option value="<?= $rol['id'] ?>"><?= htmlspecialchars($rol['nombre']) ?></option>
                <?php endforeach; ?>
        </select>
                        
        <p>Contraseña </p>
        <label for="contrasena" class="form-label"></label>
        <input type="password" class="form-control" id="contrasena" name="contrasena" required> <br><br>


        <input class="button" type="submit" value="Guardar">
        <a href="Index.php?accion=login">¿Ya tiene una cuenta? Inicie Sesion</a>
        
    </form>
    
</body>

</html>

