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

        $esAdmin = ($rol == ROL_ADMIN);

        if ($esAdmin) {
            $mensajes = $mensaje->obtenerTodosLosMensajes() ?? [];
            include "Views/chat_admin.php";
        } else {
            $mensajes = $mensaje->obtenerMensajes($usuario_id) ?? [];
            include "Views/chat.php";
        }
    }

    // Mostrar la vista de chat
    public function mostrarConversacion($otro_usuario_id)
    {
        $mensaje = new Mensaje();
        $usuario_id = $_SESSION['id'] ?? null;
        $rol = $_SESSION['rol'] ?? null;

        if (!$usuario_id || !$rol) {
            die("No hay sesión iniciada o faltan datos de usuario.");
        }

        if ($rol == ROL_ADMIN) {
            // Admin puede ver todo.
            $mensajes = $mensaje->obtenerTodosLosMensajes();
            include __DIR__ . "/../Views/chat_admin.php";
        } else {
            $mensajes = $mensaje->obtenerConversacion($usuario_id, $otro_usuario_id);
            include __DIR__ . "/../Views/chat.php";
        }
    }

    // Devolver solo los mensajes (para Ajax)
    public function listarMensajes()
    {
        $mensaje = new Mensaje();
        $usuario_id = $_SESSION['id'] ?? null;
        $rol = $_SESSION['rol'] ?? null;

        if (!$usuario_id) {
            http_response_code(401);
            exit("No autorizado");
        }

        $esAdmin = ($rol == ROL_ADMIN);
        $mensajes = $mensaje->obtenerMensajes($usuario_id, $esAdmin);

        foreach ($mensajes as $m) {
            echo "<p><strong>" . htmlspecialchars($m['usuario']) . ":</strong> " .
                nl2br(htmlspecialchars($m['mensaje'])) . "</p>";
        }
    }

    // Guardar nuevo mensaje
    public function enviar()
    {
        $mensaje = new Mensaje();

        $usuario_id = $_POST['usuario_id'];
        $receptor_id = $_POST['receptor_id'] ?? null;
        $texto = $_POST['mensaje'];

        if ($mensaje->enviarMensaje($usuario_id, $receptor_id, $texto)) {
            header("Location: index.php?accion=mostrarConversacion&usuario=$receptor_id");
        } else {
            echo "Error al emviar el mensaje";
        }
    }
}
