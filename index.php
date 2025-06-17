<?php
require_once("config/conexion.php");
require_once("controllers/ClienteC.php");
$controller = new ClienteC();

$accion = $_GET['accion'] ?? 'index';

if ($accion == 'crear') {
    $controller->crear();
} elseif ($accion == 'guardar') {
    $controller->guardar();
} elseif ($accion == 'editar') {
    $controller->editar();
} elseif ($accion == 'actualizar') {
    $controller->actualizar();
} elseif ($accion == 'borrar') {
    $controller->borrar();
} else {
    $controller->index();
}
?>