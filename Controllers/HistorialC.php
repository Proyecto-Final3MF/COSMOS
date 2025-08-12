<?php

require_once __DIR__ . '/../models/HistorialM.php';

class HistorialController {
    private $historialModel;

    public function __construct() {
        $this->historialModel = new HistorialM();
    }

   public function mostrarHistorial() {

    $search = $_GET['search'] ?? null;
    $start_date = $_GET['start_date'] ?? null;
    $end_date = $_GET['end_date'] ?? null;

    $filters_applied = !empty($search) || !empty($start_date) || !empty($end_date);

    if ($filters_applied) {
        $historial = $this->historialModel->getHistorial($search, $start_date, $end_date);
    } else {
        $historial = $this->historialModel->getHistorial();
    }

    include __DIR__ . '/../views/historial_view.php';
}
    public function registrarModificacion($usuario, $usuario_id, $accion, $item, $item_id, $obs) {
        $this->historialModel->registrarModificacion($usuario, $usuario_id, $accion, $item, $item_id, $obs);
    }
}
