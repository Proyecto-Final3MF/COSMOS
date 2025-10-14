<?php
require_once "Models/Mensaje.php";

class ChatC
{
    public function mostrarChat()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_GET['usuario_id'])) {
            echo "Usuario no especificado.";
            return;
        }

        $otroUsuario = $_GET['usuario_id'];

        $mensajes = $this->mensajeModel->obtenerConversacion($usuarioId, $otroUsuarioId);

        require_once "Views/chat.php";
    }

    public function cargarMensajes()
    {
        $usuarioId = $_SESSION['id'];
        $otroUsuarioId = $_GET['usuario_id'];
        $mensajes = (new Mensaje())->obtenerMensajesConversacion($usuarioId, $otroUsuarioId);

        if (!$usuarioId || !$otroUsuarioId) {
            http_response_code(400);
            exit("Faltan paramentros.");
        }

        $mensajeModel = new Mensaje();
        $mensajes = $mensajeModel->obtenerConversacion($usuarioId, $otroUsuarioId);

        include __DIR__ . "/../Views/mensajes.php";
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

        $otroUsuarioId = intval($_GET['usuario_id']);
        $usuarioId = $_SESSION['id'];

        $mensajeModel = new Mensaje();
        $mensajes = $mensajeModel->obtenerConversacion($usuarioId, $otroUsuarioId);

        include "Views/chat/conversacion.php";
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
        $mensaje = new Mensaje();
        $usuario_id = $_SESSION['id'] ?? null;

        if (!$usuario_id) {
            header("Location: index.php?accion=login");
            exit();
        }

        $conversaciones = $mensaje->obtenerConversaciones($usuario_id);
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
        $idSolicitud = $_GET['id_solicitud'] ?? null;
        $usuarioId = $_SESSION['id'] ?? null;

        if (!$idSolicitud || !$usuarioId) {
            $_SESSION['mensaje'] = "Error: Solicitud o usuario no especificado.";
            header("Location: index.php?accion=listarSA");
            exit();
        }

        // Obtener solicitud
        $solicitud = new Solicitud();
        $datosSolicitud = $solicitud->obtenerSolicitudPorId($idSolicitud);

        if (!$datosSolicitud) {
            $_SESSION['mensaje'] = "Error: Solicitud no econtrada.";
            header("Location: index.php?accion=listarSA");
            exit();
        }

        // Calular con quién hablar
        if ($_SESSION['rol'] == ROL_TECNICO) {
            $otroUsuarioId = $datosSolicitud['cliente_id'];
        } elseif ($_SESSION['rol'] == ROL_CLIENTE) {
            $otroUsuarioId = $datosSolicitud['tecnico_id'];
        } else {
            $_SESSION['mensaje'] = "Error: rol no válido.";
            header("Location: index.php?accion=listarSA");
            exit();
        }

        // Redirigir a la conversacion
        header("Location: index.php?accion=mostrarConversacion&usuario_id=" . $otroUsuarioId);
        exit();
    }

    // Guardar nuevo mensaje
    public function enviar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $receptor_id = $_POST['receptor_id'] ?? null;
        $mensajeTexto = trim($_POST['mensaje'] ?? '');

        if (!$receptor_id || $mensajeTexto === '') {
            header("Location: index.php?accion=mostrarConversacion");
            exit();
        }

        $mensajeModel = new Mensaje();
        $mensajeModel->enviarMensaje($_SESSION['id'], $receptor_id, $mensajeTexto);

        header("Location: index.php?accion=mostrarConversacion&usuario_id=" . $receptor_id);
        exit();
    }

    public function borrar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $receptor_id = $_GET['usuario_id'] ?? null;
        if (!$receptor_id) {
            header("Location: index.php?accion=index");
            exit();
        }

        $mensajeModel = new Mensaje();
        $mensajeModel->borrarConversacion($_SESSION['id'], $receptor_id);

        header("Location: index.php?accion=index");
        exit();
    }
}
