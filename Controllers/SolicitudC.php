<?php
require_once(__DIR__ . '/../Models/SolicitudM.php');
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
        $productos = $solicitud->obtenerProductos();
        include ("./Views/Solicitudes/FormularioS.php");
        
    }

    public function guardarS() {
        $solicitud = new Solicitud();
        $titulo = $_POST['titulo'] ?? '';
        $producto = $_POST['producto'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $prioridad = $_POST['prioridad'] ?? '';
        $usuario_id = $_SESSION['id'] ?? '';
        $solicitud->crearS($titulo, $descripcion, $producto, $usuario_id, $prioridad);

        if ($solicitud){
            header("Location: index.php?accion=redireccion");
        };
        
    }

    public function borrarS() {
        $solicitud = new Solicitud();
        $id = $_GET['id'];
        $solicitud->borrarS($id);
        header("Location: index.php?accion=redireccion");
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
            $this->historialController->registrarModificacion($usuario, $usuarioId, 'modificó', 'solicitud', $solicitudId, $obs);
        }
        return $success;
}

    public function cancelarRequest($id) {
            if (!isset($id)) {
                echo "Id invalida";
            }

            $result_status = $this->requestModel->cancelar($id);

            if ($result_status === 'updated') {
                $obs = "Solicitud cancelada por parte del tecnico, retornó a estar disponible.";
                $this->historialController->registrarModificacion($usuario, $usuarioId, 'solicitud', $solicitudId, $obs);
                exit();
            } elseif ($result_status === 'deleted') {
                $obs = "Solicitud cancelada por parte del cliente, removida completamente.";
                $this->historialController->registrarModificacion($usuario, $usuarioId, 'solicitud', $solicitudId, $obs);
                exit();
            } else {
                Echo "Cancelacion fallada";
                exit();
            }
        }
    }
?>