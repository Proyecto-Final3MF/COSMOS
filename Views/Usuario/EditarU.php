<?php
require_once ("./Views/include/UH.php");
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="./Assets/css/Main.css">
</head>
<body>
    <div class="contenedor-formulario">
    <section>
<h3>Editar Usuario</h3>

<form method="POST" action="Index.php?accion=actualizarU">
    
    <input type="hidden" name="id" value="<?= $datos['id'] ?>">
        
    <p> Nombre: </p>  <input type="text" name="nombre" value="<?= $datos['nombre'] ?>"><br>
        
   <p> Email: </p> <input type="mail" name="email" value="<?= $datos['email'] ?>"><br>
       
    <input type="submit" value="Guardar cambios">

</form>
</section>
<div class="botones-container">
        <a href="index.php?accion=redireccion"><button class="btn btn-boton">Volver</button></a>
    </div>
</div>
<script src="Assets/js/trancicion.js"></script>
</body>
</html> 