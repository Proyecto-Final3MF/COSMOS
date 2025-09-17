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
            $_SESSION['mensaje'] = "Solicitud guardada existosamente";
            $this->historialController->registrarModificacion($user['nombre'], $usuario_id, 'creó la solicitud', $titulo, $id, null);
            header("Location: index.php?accion=redireccion");
        };
        
    }

    public function borrarS() {
        $solicitud = new Solicitud();
        $id = $_GET['id'];
        $solicitud->borrarS($id);
        $_SESSION['mensaje'] = "Solicitud eliminada existosamente";
        $this->historialController->registrarModificacion($user['nombre'], $usuario_id, 'eliminó la solicitud', $titulo, $id, null);
        header("Location: index.php?accion=redireccion");
    }

    public function listarSLU(){
        $id_usuario = $_SESSION['id'] ?? null;
        if ($id_usuario === null) {
            header("Location: index.php?accion=login");
            exit();
        }
        
        $solicitud = new Solicitud();
        $resultados = $solicitud->listarSLU($id_usuario);
        include("./Views/Solicitudes/ListadoS.php");
    }


    public function ListarTL() {
    if (isset($_SESSION['id'])) {
        $usuarioId = $_SESSION['id'];
        return $this->solicitudModel->ListarTL($usuarioId);
    } else {
        echo "paso algo mal";
        return [];
    }
    }
    public function getOcupadasData($estado_filter = 'all') {
        return $this->solicitudModel->getSolicitudesOcupadas($estado_filter);
    }

    public function handleSelectSolicitud($solicitudId, $usuarioId = null) {
        $newEstadoId = 2;
        $success = $this->solicitudModel->updateSolicitudEstado($solicitudId, $newEstadoId);

        if ($success) {
            $obs = "Estado de la solicitud alterado para el ID " . $newEstadoId;
            $this->historialController->registrarModificacion($usuario, $usuarioId, 'seleccionó', 'solicitud', $solicitudId, $obs);
        }
        return $success;
}

    public function cancelarRequest($id) {
            if (!isset($id)) {
                echo "Id invalida";
            }

            $result_status = $this->requestModel->cancelar($id);

            if ($result_status === 'updated') {
                //actualizar esto:
                $obs = "Solicitud cancelada por parte del tecnico, retornó a estar disponible.";
                $this->historialController->registrarModificacion($usuario, $usuarioId, 'solicitud', $solicitudId, $obs);
                exit();
            } elseif ($result_status === 'deleted') {
                //actualizar esto:
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