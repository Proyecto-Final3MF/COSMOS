<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != ROL_CLIENTE) {
    header("Location: index.php?accion=redireccion");
    exit();
}  

require_once ("./Views/include/UH.php");
require_once ("./Models/ProductoM.php");

$solicitudController = new SolicitudC();
$solicitudes = $solicitudController->getLibresData();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href="./Assets/css/inicio.css" />
</head>
<body>
<div>
    <h2>¿En qué podemos ayudarte?</h2> <br>
    <center>
    <a href="index.php?accion=listarP"><button class="btn btn-boton">Ver Mis Productos</button></a>
    <a href="index.php?accion=listarS"><button class="btn btn-boton">Ver Mis Solicitudes</button></a>
    </center>
</div>
</body>
</html>