<?php


require_once __DIR__ . '/../models/HistorialModel.php';

class HistorialController {
    private $historialModel;

    public function __construct() {
        $this->historialModel = new HistorialM();
    }

    public function mostrarHistorial() {
        $historial = $this->historialModel->getHistorial();
        include __DIR__ . '/../views/historial_view.php';
    }
    public function registrarModificacion($usuario_id, $accion, $item, $item_id, $obs) {
        $this->historialModel->registrarModificacion($usuario_id, $accion, $item, $item_id, $obs);
    }
}