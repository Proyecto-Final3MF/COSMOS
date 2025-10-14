<?php
require_once(__DIR__ . '/../Models/SolicitudM.php');
require_once(__DIR__ . '/solicitud_historiaC.php');
require_once ("./Views/include/popup.php");

class SolicitudC {
    private $solicitudModel;
    private $historiaC;

    public function __construct() {
        $this->solicitudModel = new Solicitud();
        $this->historiaC = new HistoriaC();
    }

    public function formularioS(){ 
        $id_usuario = $_SESSION['id'] ?? null;
        
        if ($id_usuario == null) {
            header("Location: index.php?accion=login");
            exit();
        } 
        
        $solicitud = new Solicitud();
        
        $productos = $solicitud->obtenerProductos($id_usuario);
        $producto_preseleccionado_id = null;
        
        include ("./Views/Solicitudes/Cliente/FormularioS.php");
    }

    public function guardarS() {
        $solicitud = new Solicitud();
        $titulo = $_POST['titulo'] ?? '';
        $producto = $_POST['producto'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $prioridad = $_POST['prioridad'] ?? '';
        $usuario_id = $_SESSION['id'] ?? '';

        $id_solicitud = $solicitud->crearS($titulo, $descripcion, $producto, $usuario_id, $prioridad);

        if ($id_solicitud) {
            $_SESSION['mensaje'] = "Solicitud guardada existosamente";

            $this->historiaC->registrarEvento($id_solicitud, "Solicitud creada");
            
            header("Location: index.php?accion=redireccion");
        } else {
            $_SESSION['error'] = "Error al guardar la solicitud.";
            header("Location: index.php?accion=redireccion");
        }
    }

    public function guardarSU() {
        $solicitud = new Solicitud();
        $titulo = $_POST['titulo'] ?? '';
        $producto = $_POST['producto'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $prioridad = 'urgente'; 
        
        $usuario_id = $_SESSION['id'] ?? '';
        
        if (empty($titulo) || empty($producto) || empty($descripcion) || empty($usuario_id)) {
             $_SESSION['mensaje'] = "Error: Faltan campos obligatorios en la solicitud urgente.";
             header("Location: index.php?accion=redireccion");
             exit();
        }

        $solicitud->crearS($titulo, $descripcion, $producto, $usuario_id, $prioridad);

        if ($solicitud){
            $_SESSION['mensaje'] = "Solicitud urgente guardada exitosamente";
            // Lógica adicional (historial, etc.)
            $this->historiaC->registrarEvento($id_solicitud, "Solicitud creada");
            header("Location: index.php?accion=listarSLU");
        } else {
             $_SESSION['mensaje'] = "Error al guardar la solicitud urgente.";
             header("Location: index.php?accion=redireccion");
        }
    }

    public function borrarS() {
        $solicitud = new Solicitud();
        $id = $_GET['id'];
        $solicitud->borrarS($id);
        $_SESSION['mensaje'] = "Solicitud eliminada existosamente";
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
            $search = $_GET['search'] ?? null;
            return $this->solicitudModel->ListarTL($usuarioId, $search);
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
            $this->historiaC->registrarEvento($id_soli, "Solicitud asignada");
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

    public function listarST() {
        $id_usuario = $_SESSION['id'] ?? null;
        if ($id_usuario == null) {
            header("Location: index.php?accion=login");
            exit();
        }   
        $solicitud = new Solicitud();
        $resultados = $solicitud->listarST($id_usuario);
        include("./Views/Solicitudes/listadoST.php");
    }
    
    public function editarSF(){
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['mensaje'] = "Error: ID de solicitud no proporcionado.";
            header("Location: index.php?accion=redireccion");
            exit();
        }

        $datosSolicitud = $this->solicitudModel->obtenerSolicitudPorId($id);
        if (!$datosSolicitud) {
            $_SESSION['mensaje'] = "Error: Solicitud no encontrada.";
            header("Location: index.php?accion=redireccion");
            exit();
        }

        // Obtener la lista de estados para el select
        $estados = $this->solicitudModel->obtenerEstados();

        // Si todo está bien, simplemente incluye la vista.
        // No hay necesidad de una redirección aquí.
        include("./Views/Solicitudes/editarSF.php");
    }
    public function actualizarSF() {
        $id = $_POST['id'] ?? null;
        $descripcion = $_POST['descripcion'] ?? '';
        $estado_id = $_POST['estado'] ?? null;

        if (!$id || empty($descripcion) || !$estado_id) {
            $_SESSION['mensaje'] = "Error: Todos los campos son obligatorios.";
            header("Location: index.php?accion=redireccion");
            exit();
        }

        if ($this->solicitudModel->actualizarS($id, $descripcion, $estado_id)) {
            $_SESSION['mensaje'] = "Solicitud actualizada exitosamente.";
            header("Location: index.php?accion=redireccion");
            exit();
        } else {
            $_SESSION['mensaje'] = "Error al actualizar la solicitud.";
            header("Location: index.php?accion=redireccion");
            exit();
        }
    }

    public function cancelarS() {
        $id_soli = $_GET['id_solicitud'] ?? null;
        $usuarioId = $_SESSION['id'] ?? null;

        if ($id_soli === null || $usuarioId === null) {
            $_SESSION['mensaje'] = "Error: ID de solicitud o usuario no proporcionado.";
            header("Location: index.php?accion=listarSA");
            exit();
        }
        
        $solicitud = $this->solicitudModel->obtenerSolicitudPorId($id_soli);
        if (!$solicitud) {
            $_SESSION['mensaje'] = "Error: La solicitud no existe.";
            header("Location: index.php?accion=listarSA");
            exit();
        }

        // Asegurarse de que el usuario es el técnico asignado o el cliente que la creó
        if ($solicitud['tecnico_id'] != $usuarioId && $solicitud['cliente_id'] != $usuarioId) {
            $_SESSION['mensaje'] = "No tienes permiso para cancelar esta solicitud.";
            header("Location: index.php?accion=listarSA");
            exit();
        }

         if ($this->solicitudModel->cancelarS($id_soli)) {
            $_SESSION['mensaje'] = "Solicitud cancelada exitosamente.";
            $this->historiaC->registrarEvento($id_solicitud, "Solicitud cancelada");
            
            // Asumo que tienes definidas estas constantes
            define('ROL_TECNICO', 1);
            define('ROL_CLIENTE', 2);
            
            if (isset($_SESSION['rol']) && $_SESSION['rol'] == ROL_TECNICO) {
                header("Location: index.php?accion=listarTL"); // Redirigir a solicitudes disponibles
            } elseif (isset($_SESSION['rol']) && $_SESSION['rol'] == ROL_CLIENTE) {
                header("Location: index.php?accion=listarSLU"); // Redirigir a sus solicitudes
            } else {
                // Si el rol no es ni técnico ni cliente, puedes redirigir a una página predeterminada
                header("Location: index.php?accion=redireccion");
            }
            exit();
        } else {
            $_SESSION['mensaje'] = "Error al cancelar la solicitud.";
            header("Location: index.php?accion=listarSA");
            exit();
        }
    }

    public function formularioUS(){ 
        // Obtener el ID del usuario de la sesión
        $id_usuario = $_SESSION['id'] ?? null;
        
        if ($id_usuario == null) {
            header("Location: index.php?accion=login");
            exit();
        } 
        
        $solicitud = new Solicitud();
        
        // 1. Obtener TODOS los productos (para llenar el <select> en la vista original, 
        //    or just to get the name for the restricted view)
        $productos = $solicitud->obtenerProductos($id_usuario);
        
        // 2. Obtener el ÚLTIMO producto creado (devuelve un array o null)
        $ultimo_producto = $solicitud->obtenerProductoUrgente($id_usuario);
        
        // 3. Establecer el ID a preseleccionar. 
        $producto_preseleccionado_id = $ultimo_producto['id'] ?? null; 

        // Incluye la vista que contendrá el formulario (use the FormularioUS.php name)
        include ("./Views/Solicitudes/Cliente/FormularioUS.php");
    }
}
?>