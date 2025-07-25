<?
    require_once("config/conexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>

<header>
    <h2>Registrarse</h2>
</header>

<body>
    
    <form method="POST" action="Index.php?accion=guardar">
        
        <p>Usuario: </p>
        <label for="usuario" class="form-label"></label>
        <input type="text" class="form-control" id="usuario" name="usuario" required> <br><br>

        <p>Email: </p>
        <label for="mail" class="form-label"></label>
        <input type="mail" class="form-control" id="mail" name="mail" required> <br><br>
                        
        <p>Rol:</p>
        <option value="">Selecciona una categoría</option>
        <?php foreach ($rol as $Rol): ?>
            <option value="<?= $Rol['id'] ?>"><?= htmlspecialchars($Rol['nombre']) ?></option>
        <?php endforeach; ?> <br><br>
                        
        <p>Contraseña: </p>
        <label for="contrasena" class="form-label"></label>
        <input type="password" class="form-control" id="contrasena" name="contrasena" required> <br><br>


        <input type="submit" value="Guardar">
        <a href="./Login.php">¿Ya tiene una cuenta? Inicie Sesion</a>
        
    </form>
    
</body>

</html>
<link rel="stylesheet" href="css.css">
