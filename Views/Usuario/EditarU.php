<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="./Assets/css/Formulario.css">
</head>
<body>
    
<h2>Editar Usuario</h2>

<form method="POST" action="Index.php?accion=actualizar">
    
    <input type="hidden" name="id" value="<?= $datos['id'] ?>">
        
    Nombre: <input type="text" name="nombre" value="<?= $datos['nombre'] ?>"><br>
        
    Email: <input type="mail" name="email" value="<?= $datos['email'] ?>"><br>
       
    <input type="submit" value="Guardar cambios">

</form>
</body>
</html>