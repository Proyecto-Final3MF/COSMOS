<?php
require_once "Models/Mensaje.php";
require_once "Models/SolicitudM.php";

class ChatC
{
    private $mensajeModel;

    public function __construct()
    {
        $this->mensajeModel = new Mensaje();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
   public function mostrarChat()
    {
        $usuarioId = $_SESSION['id'] ?? null;
        $otroUsuarioId = $_GET['usuario_id'] ?? null;
        $solicitud_id = $_GET['solicitud_id'] ?? null;

        if (!$usuarioId || !$otroUsuarioId || !$solicitud_id) {
            echo "Error: faltan datos del chat.";
            return;
        }

        $mensajes = $this->mensajeModel->obtenerConversacion($usuarioId, $otroUsuarioId, $solicitud_id);
        require_once "Views/chat.php";
    }

    public function cargarMensajes()
    {
        $usuarioId = $_SESSION['id'] ?? null;
        $otroUsuarioId = $_GET['usuario_id'] ?? null;
        $solicitud_id = $_GET['solicitud_id'] ?? null;

        if (!$usuarioId || !$otroUsuarioId || !$solicitud_id) {
            http_response_code(400);
            exit("Faltan parámetros.");
        }

        $mensajes = $this->mensajeModel->obtenerConversacion($usuarioId, $otroUsuarioId, $solicitud_id);

        foreach ($mensajes as $m) {
            $nombre = ($m['usuario_id'] == $usuarioId) ? 'Tú' : ($m['emisor'] ?? '???');
            echo "<p><strong>" . htmlspecialchars($nombre) . ":</strong> " .
                 nl2br(htmlspecialchars($m['mensaje'])) . "</p>";
        }
    }

    // Mostrar la vista de chat
    public function mostrarConversacion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_GET['usuario_id'])) {
            echo "Error: no se especificó el usuario receptor.";
            return;
        }

        $usuarioId = $_SESSION['id'] ?? null;
        $otroUsuarioId = intval($_GET['usuario_id'] ?? null);
        $solicitud_id = $_GET['solicitud_id'] ?? null;

        if (!$usuarioId || !$otroUsuarioId || !$solicitud_id) {
            echo "Error: no se especificoel usuario receptor.";
            return;
        }

        // Crear instancia de Mensaje
        $mensajeModel = new Mensaje();

        // Obtener todos los mensajes entre los dos usuarios
        $mensajes = $mensajeModel->obtenerConversacion($usuarioId, $otroUsuarioId, $solicitud_id);

        include __DIR__ . "/../Views/conversaciones.php";
    }

    // Devolver solo los mensajes (para Ajax)
    public function listarMensajes()
    {
        $mensaje = new Mensaje();
        $usuario_id = $_SESSION['id'] ?? null;
        $rol = $_SESSION['rol'] ?? null;
        // Si no hay sesión, se devuelve error 401
        if (!$usuario_id) {
            http_response_code(401);
            exit("No autorizado");
        }

        $esAdmin = ($rol == ROL_ADMIN);
        $mensajes = $mensaje->obtenerMensajes($usuario_id, $esAdmin);
        // Recorre los mensajes y los imprime en HTML
        foreach ($mensajes as $m) {
            echo "<p><strong>" . htmlspecialchars($m['usuario']) . ":</strong> " .
                nl2br(htmlspecialchars($m['mensaje'])) . "</p>";
        }
    }

    public function listarConversaciones()
    {
        $usuario_id = $_SESSION['id'] ?? null;
        if (!$usuario_id) {
            header("Location: index.php?accion=login");
            exit();
        }

        $conversaciones = $this->mensajeModel->obtenerConversaciones($usuario_id);
        include __DIR__ . "/../Views/conversaciones.php";
    }
    // Lista todas las conversaciones de un usuario
    public function registroChats()
    {
        $mensaje = new Mensaje();
        $conversaciones = $mensaje->obtenerTodasLasConversaciones();
        include __DIR__ . "/../Views/registroChats.php";
    }

    public function abrirChat()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $idSolicitud = intval($_GET['id_solicitud'] ?? 0);
        $usuarioId = $_SESSION['id'] ?? null;

        if (!$idSolicitud || !$usuarioId) {
            $_SESSION['mensaje'] = "Error: Solicitud o usuario no especificado.";
            header("Location: index.php?accion=listarSA");
            exit();
        }

        // Obtener datos de la solicitud
        require_once "Models/Solicitud.php";
        $solicitud = new Solicitud();
        $datosSolicitud = $solicitud->obtenerSolicitudPorId($idSolicitud);

        if (!$datosSolicitud) {
            $_SESSION['mensaje'] = "Error: Solicitud no encontrada.";
            header("Location: index.php?accion=listarSA");
            exit();
        }

        $otroUsuarioid = ($_SESSION['rol'] == ROL_TECNICO)
            ? $datosSolicitud['cliente_id']
            : $datosSolicitud['tecnico_id'];

        // Redirigir a la conversación
        header("Location: index.php?accion=mostrarChat&usuario_id={$otroUsuarioId}&solicitud_id={$idSolicitud}");
        exit();
    }

    // Guardar nuevo mensaje
    public function enviar()
    {
        $usuarioId = $_SESSION['id'] ?? null;
        $receptor_id = $_POST['receptor_id'] ?? null;
        $solicitud_id = $_POST['solicitud_id'] ?? null;
        $mensajeTexto = trim($_POST['mensaje'] ?? '');

        if (!$usuarioId || !$receptor_id || !$solicitud_id || $mensajeTexto === '') {
            http_response_code(400);
            exit("Error: faltan parámetros o mensaje vacío.");
        }

        $this->mensajeModel->enviarMensaje($usuarioId, $receptor_id, $mensajeTexto, $solicitud_id);

        // Devolver éxito
        http_response_code(200);
        exit();
    }

    public function borrar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $receptor_id = $_POST['receptor_id'] ?? null;
        $usuario_Id = $_POST['usuario_id'] ?? $_SESSION['id'];

        if (!$receptor_id) {
            header("Location: index.php?accion=listarConversaciones");
            exit();
        }

        $mensajeModel = new Mensaje();
        $mensajeModel->borrarConversacion($usuario_Id, $receptor_id);

        header("Location: index.php?accion=listarConversaciones");
        exit();
    }
}
