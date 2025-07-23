<?php
session_start();
require_once("Config/conexion.php");
require_once("controllers/SesionC.php");

// Obtener la acción solicitada
$accion = $_GET['accion'] ?? 'index';

// Definir acciones públicas (que no requieren autenticación)
$acciones_publicas = ['login', 'autenticar'];

// Verificar autenticación para acciones privadas
if (!in_array($accion, $acciones_publicas)) {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?accion=login");
        exit;
    }
}

// Enrutamiento de acciones
switch ($accion) {
    // === ACCIONES DE USUARIO ===
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
}
?>
