<?php
session_start();
require_once("Config/conexion.php");
require_once("controllers/usuarioC.php");

$accion = $_GET['accion'] ?? 'index';

$acciones_publicas = ['login', 'autenticar', 'register', 'redirigir', 'guardar'];

if (!in_array($accion, $acciones_publicas)) {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?accion=login");
        exit;
    }
}

switch ($accion) {
    case 'login':
        $controller = new UsuarioC();
        $controller->login();
        break;
        
    case 'autenticar':
        $controller = new UsuarioC();
        $controller->autenticar();
        break;
        
    case 'logout':
        $controller = new UsuarioC();
        $controller->logout();
        break;

    case 'register':
        $controller = new UsuarioC();
        $controller->crear();
        break;

    case 'guardar':
        $controller = new UsuarioC();
        $controller->guardar();
        break;
    
    case 'redirigir':
        $controller = new UsuarioC();
        $controller->redirigir();
        break;
    case 'default':
        $controller = new UsuarioC();
        $controller->login();
        break;
}
?>
