<?php
require_once(__DIR__ . '/../models/SolicitudM.php');
require_once(__DIR__ . '/HistorialController.php');

class SolicitudController {
    private $solicitudModel;
    private $historialController;

    public function __construct() {
        $this->solicitudModel = new Solicitud();
        $this->historialController = new HistorialController();
    }

    public function crear() {
        
        $solicitud = new Solicitud();
        $categorias = $solicitud->obtenerCategorias();
        include("views/Solicitudes/crear.php");
    }

    public function guardar() {
        
        $ticket = new Ticket();
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $categoria_id = $_POST['categoria_id'];
        $prioridad = $_POST['prioridad'];
        $usuario_id = $_SESSION['usuario_id'];
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