<?php
require_once __DIR__ . '/controllers/HistorialController.php';

// Um roteador muito simples. Em uma aplicação maior, você usaria um framework de roteamento.
$action = $_GET['action'] ?? 'mostrarHistorial'; // Padrão é mostrar o histórico

$controller = new HistorialController();

if ($action === 'mostrarHistorial') {
    $controller->mostrarHistorial();
}
// Adicione outras ações conforme necessário
?>