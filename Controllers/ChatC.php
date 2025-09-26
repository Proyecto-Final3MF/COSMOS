<?php
require_once "Models/Mensaje.php";

class ChatC
{
    public function mostrarChat()
    {
        $mensaje = new Mensaje();
        $usuario_id = $_SESSION['id'] ?? null;
        $rol = $_SESSION['rol'] ?? null;

        if (!$usuario_id || !$rol) {
            die("No hay sesión iniciada o faltan datos de usuario.");
        }
        // Verifica si el usuario es administrador
        $esAdmin = ($rol == ROL_ADMIN);

        // Si es admin, ve todos los mensajes y carga la vista admin
        if ($esAdmin) {
            $mensajes = $mensaje->obtenerTodosLosMensajes() ?? [];
            include "Views/chat_admin.php";
        } else {
            // Si es usuario normal, solo ve sus propios mensajes
            $mensajes = $mensaje->obtenerMensajes($usuario_id) ?? [];
            include "Views/chat.php";
        }
    }

    // Mostrar la vista de chat
    public function mostrarConversacion($otro_usuario_id)
    {
        $mensaje = new Mensaje();
        $usuario_id = $_SESSION['id'] ?? null;
        $otro_usuario_id = $_GET['usuario_id'] ?? null;

        if (!$otro_usuario_id) {
            echo "Debes seleccionar un usuario para conversar.";
            return;
        }

        $mensajes = $mensaje->obtenerConversacion($usuario_id, $otro_usuario_id);
        include __DIR__ . "/../Views/chat.php";
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

    // Guardar nuevo mensaje
    public function enviar()
    {
        $mensaje = new Mensaje();

        $usuario_id = $_POST['usuario_id'];
        $receptor_id = $_POST['receptor_id'] ?? null;
        $texto = $_POST['mensaje'];

        if ($mensaje->enviarMensaje($usuario_id, $receptor_id, $texto)) {
            header("Location: index.php?accion=mostrarConversacion&usuario_id=$receptor_id");
            exit();
        } else {
            echo "Error al emviar el mensaje";
        }
    }
}
