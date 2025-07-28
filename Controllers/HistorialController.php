<?php


require_once __DIR__ . '/../models/HistorialModel.php';

class HistorialController {
    private $historialModel;

    public function __construct() {
        $this->historialModel = new HistorialModel();
    }

    public function mostrarHistorial() {
        $historial = $this->historialModel->getHistorial();
        include __DIR__ . '/../views/historial_view.php';
    }
    public function registrarModificacao($usuario_id, $item, $solicitud_id, $obs) {
        $this->historialModel->registrarModificacao($usuario_id, $item, $solicitud_id, $obs);
    }
}