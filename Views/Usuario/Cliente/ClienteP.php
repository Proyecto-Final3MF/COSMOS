<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != ROL_CLIENTE) {
    header("Location: index.php?accion=redireccion");
    exit();
}  

require_once ("./Views/include/UH.php");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Panel de Cliente</title>
</head>
<body>
<div>
    <h2>¿En qué podemos ayudarte?</h2> <br>
    <div class="btn-container">
    <a href="index.php?accion=listarP"><button class="btn btn-boton">Ver Mis Productos</button></a>
    <a href="index.php?accion=listarSLU"><button class="btn btn-boton">Ver Mis Solicitudes Sin Asignar</button></a>
    <a href="index.php?accion=listarSA"><button class="btn btn-boton">Ver Mis Solicitudes Aceptadas</button></a>
    <a href="index.php?accion=listarSFU"><button class="btn btn-boton">Ver Mis Solicitudes Terminadas</button></a>
    
    </div>
</div>
</body>
</html>