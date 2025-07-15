<?php
//Se necesita el formulario de solicitudes para q funcione.
require_once("../config/conexion.php");

$conexion = conectar();

$sql = "UPDATE solicitud set estado_id='2' WHERE id = $id";
header("Location:libres.php");
?>
