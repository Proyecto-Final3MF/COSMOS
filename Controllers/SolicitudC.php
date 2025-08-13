<?php
require_once(__DIR__ . '/../models/SolicitudM.php');
require_once(__DIR__ . '/HistorialC.php');

class SolicitudC {
    private $solicitudModel;
    private $historialController;

    public function __construct() {
        $this->solicitudModel = new Solicitud();
        $this->historialController = new HistorialController();
    }

    public function formularioS(){  
        $solicitud = new Solicitud();
        $categorias = $solicitud->obtenerProductos();
        include ("./Views/Solicitudes/FormularioS.php");
        
    }

    public function crearS() {
        
    }

    public function guardar() {
        $solicitud = new Solicitud();
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
        $this->historialController->registrarModificacion(
            $usuario,
            $usuarioId,
            'modifico',
            'solicitud',
            $solicitudId,
            $obs
        );
    }
    return $success;
}

public function cancelarRequest($id) {
        if (!isset($id)) {
            echo "Id invalida";
        }

        $result_status = $this->requestModel->cancelar($id);

        if ($result_status === 'updated') {
            $obs = "Solicitud cancelada por parte del tecnico, volvio a estar disponible.";
            $this->historialController->registrarModificacion(
                $usuario,
                $usuarioId,
                'solicitud',
                $solicitudId,
                $obs
            );
            exit();
        } elseif ($result_status === 'deleted') {
            $obs = "Solicitud cancelada por parte del cliente, removida completamente.";
            $this->historialController->registrarModificacion(
                $usuario,
                $usuarioId,
                'solicitud',
                $solicitudId,
                $obs
            );
            exit();
        } else {
            Echo "Cancelacion fallada";
            exit();
        }
    }
}
?>