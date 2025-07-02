<?php
// Este es el punto de entrada principal (front controller)
require_once("controllers/SolicitudController.php");

$controller = new SolicitudController();

// Determinar la acción a realizar
$action = isset($_GET['action']) ? $_GET['action'] : 'home'; // 'home' es una acción por defecto, puedes cambiarla

switch ($action) {
    case 'ocupadas':
        $controller->listarSolicitudesOcupadas();
        break;
    case 'libres':
        $controller->listarSolicitudesLibres();
        break;
    // Puedes agregar más casos para otras acciones (ej: 'detalle', 'crear', etc.)
    default:
        // Si no se especifica una acción válida, puedes redirigir o mostrar una página por defecto
        echo "Página no encontrada o acción no especificada.";
        // O podrías llamar a una acción por defecto, por ejemplo:
        // $controller->listarSolicitudesOcupadas();
        break;
}
?>