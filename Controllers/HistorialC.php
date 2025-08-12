<?php


require_once __DIR__ . '/../models/HistorialM.php';

class HistorialController {
    private $historialModel;

    public function __construct() {
        $this->historialModel = new HistorialM();
    }

   public function mostrarHistorial() {
    // Get filter values from the URL
    $search = $_GET['search'] ?? null;
    $start_date = $_GET['start_date'] ?? null;
    $end_date = $_GET['end_date'] ?? null;

    // Check if any filter has been applied
    $filters_applied = !empty($search) || !empty($start_date) || !empty($end_date);

    if ($filters_applied) {
        // If filters are applied, call the function with parameters
        $historial = $this->historialModel->getHistorial($search, $start_date, $end_date);
    } else {
        // If no filters are applied, get all history records
        $historial = $this->historialModel->getHistorial();
    }

    // Include the view to display the results
    include __DIR__ . '/../views/historial_view.php';
}
    public function registrarModificacion($usuario, $usuario_id, $accion, $item, $item_id, $obs) {
        $this->historialModel->registrarModificacion($usuario, $usuario_id, $accion, $item, $item_id, $obs);
    }
}
