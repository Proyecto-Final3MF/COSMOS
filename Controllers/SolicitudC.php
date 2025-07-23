<?php
require_once(__DIR__ . '/../models/SolicitudM.php');
require_once(__DIR__ . '/HistorialController.php'); // Include HistorialController

class SolicitudController {
    private $solicitudModel;
    private $historialController; // Declare historialController

    public function __construct() {
        $this->solicitudModel = new Solicitud();
        $this->historialController = new HistorialController(); // Instantiate HistorialController
    }

    public function getLibresData() {
        return $this->solicitudModel->getSolicitudesDisponibles();
    }

    public function getOcupadasData($estado_filter = 'all') {
        return $this->solicitudModel->getSolicitudesOcupadas($estado_filter);
    }

    public function handleSelectSolicitud($solicitudId, $usuarioId = null) {
        $newEstadoId = 2;
        $success = $this->solicitudModel->updateSolicitudEstado($solicitudId, $newEstadoId);

        if ($success) {
        $obs = "Estado de la solicitud alterado para el ID " . $newEstadoId;
        $this->historialController->registrarModificacao(
            $usuarioId,
            'solicitud',
            $solicitudId,
            $obs
        );
    }
    return $success;
}
}
?>