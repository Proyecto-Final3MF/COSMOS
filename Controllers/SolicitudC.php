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
        include ("./Views/Solicitudes/Clientes/FormularioS.php");
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
            //$this->historialController->registrarModificacion($_SESSION['nombre'], $usuario_id, 'creó la solicitud', $titulo, $id, null);
            header("Location: index.php?accion=redireccion");
        };
    }

    public function borrarS() {
        $solicitud = new Solicitud();
        $id = $_GET['id'];
        $solicitud->borrarS($id);
        $_SESSION['mensaje'] = "Solicitud eliminada existosamente";
        //$this->historialController->registrarModificacion($_SESSION['nombre'], $usuario_id, 'eliminó la solicitud', $titulo, $id, null);
        header("Location: index.php?accion=redireccion");
    }

    public function listarSLU(){
        $id_usuario = $_SESSION['id'] ?? null;
        if ($id_usuario == null) {
            header("Location: index.php?accion=login");
            exit();
        }  
        $solicitud = new Solicitud();
        $resultados = $solicitud->listarSLU($id_usuario);
        include("./Views/Solicitudes/Cliente/ListadoSLU.php");
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

    public function asignarS() {
        $id_usuario = $_SESSION['id'] ?? null;
        $id_soli = $_GET['id_solicitud'] ?? null;

        if ($id_usuario === null || $id_soli === null) {
            $_SESSION['mensaje'] = "Error: ID de usuario o solicitud no proporcionado.";
            header("Location: index.php?accion=listarTL");
            exit();
        }
        
        $success = $this->solicitudModel->asignarS($id_usuario, $id_soli);

        if ($success) {
            $_SESSION['mensaje'] = "Solicitud aceptada exitosamente";
            header("Location: index.php?accion=listarTL");
            exit();
        } else {
            $_SESSION['mensaje'] = "Error al aceptar la solicitud.";
            header("Location: index.php?accion=listarTL");
            exit();
        }
    }

    public function listarSA() {
        $id_usuario = $_SESSION['id'] ?? null;
        if ($id_usuario == null) {
            header("Location: index.php?accion=login");
            exit();
        }  
        $solicitud = new Solicitud();
        $resultados = $solicitud->listarSA($id_usuario);
        include("./Views/Solicitudes/listadoSA.php");
    }

    public function EditarSF(){
        var_dump ($_GET); die();
        include("./Views/Solicitudes/Tecnico/EditarSF.php");
    }
}
?>