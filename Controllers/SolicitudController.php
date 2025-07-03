<?php
// controllers/SolicitudController.php

require_once(__DIR__ . '/../models/Solicitud.php');

class SolicitudController {
    private $solicitudModel;

    public function __construct() {
        $this->solicitudModel = new Solicitud();
    }

    public function getLibresData() {
        return $this->solicitudModel->getSolicitudesDisponibles();
    }

    public function getOcupadasData($estado_filter = 'all') {
        return $this->solicitudModel->getSolicitudesOcupadas($estado_filter);
    }

    public function handleSelectSolicitud($solicitudId) {
        $newEstadoId = 2; // Supondo que 2 é o estado 'em progresso'
        $success = $this->solicitudModel->updateSolicitudEstado($solicitudId, $newEstadoId);
        return $success;
    }
}
?>