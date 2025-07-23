<?php
require_once("Config/conexion.php");
require_once("Controllers/LoginC.php");
$controller = new LoginController();

$accion = $_GET['accion'] ?? 'index';

if ($accion == 'login') {
    $controller->login();
} else if($accion == 'register'){
    $controller->register();
} else {
    $controller->index();
}
?>