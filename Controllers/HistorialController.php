<?php
//echo "DEBUG: HistorialController.php está sendo carregado.<br>";

require_once __DIR__ . '/../models/HistorialModel.php';

class HistorialController {
    private $historialModel;

    public function __construct() {
        $this->historialModel = new HistorialModel();
    }

    /**
     * Exibe a página do histórico.
     */
    public function mostrarHistorial() {
        $historial = $this->historialModel->getHistorial();
        // Inclui a view para exibir o histórico
        include __DIR__ . '/../views/historial_view.php';
    }
    public function registrarModificacao($usuario_id, $item, $solicitud_id, $obs) {
        $this->historialModel->registrarModificacao($usuario_id, $item, $solicitud_id, $obs);
    }
}