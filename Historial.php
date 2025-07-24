<?php
require_once __DIR__ . '/controllers/HistorialController.php';

$action = $_GET['action'] ?? 'mostrarHistorial';

$controller = new HistorialController();

if ($action === 'mostrarHistorial') {
    $controller->mostrarHistorial();
}
// Adicione outras ações conforme necessário
?>