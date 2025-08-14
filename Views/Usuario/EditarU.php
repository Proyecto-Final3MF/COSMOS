<?php
    require_once("views/includes/header.php");
?>

<h2>Editar Usuario</h2>

<form method="POST" action="Index.php?accion=actualizar">
    
    <input type="hidden" name="id" value="<?= $datos['id'] ?>">
        
    Nombre: <input type="text" name="nombre" value="<?= $datos['nombre'] ?>"><br>
        
    Email: <input type="mail" name="email" value="<?= $datos['email'] ?>"><br>
       
    <input type="submit" value="Guardar cambios">

</form>