<?php
session_start();
require_once("Config/conexion.php");
require_once("controllers/usuarioC.php");

$accion = $_GET['accion'] ?? 'index';

$acciones_publicas = ['login', 'autenticar', 'register', 'guardar'];

if (!in_array($accion, $acciones_publicas)) {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?accion=login");
        exit;
    }
}

const ROL_TECNICO = 1;
const ROL_CLIENTE = 2; 

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

    case 'redireccion':
        if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
            if ($_SESSION['rol'] == ROL_CLIENTE) {
                include("./Views/Usuario/Cliente/ClienteP.php");
            } elseif ($_SESSION['rol'] == ROL_TECNICO) {
                include("./Views/Usuario/Tecnico/TecnicoP.php");
            } else {
                echo "<h1>Error: Rol no reconocido.</h1>";
                echo "<p><a href='index.php?accion=logout'>Cerrar Sesión</a></p>";
            }
        } else {
            header("Location: index.php?accion=login");
            exit();
        }
        break;
    
    default:
        if (isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=redireccion");
        } else {
            header("Location: index.php?accion=login");
        }
        exit();
}
?>
