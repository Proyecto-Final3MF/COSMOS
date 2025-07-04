<?php
require_once("config/conexion.php");
require_once("controllers/ProductoController.php");
$controller = new ProductoController();

$accion = $_GET['accion'] ?? 'index';

if ($accion == 'crear') {
    $controller->crear();
} else {
    $controller->index();
}
?>