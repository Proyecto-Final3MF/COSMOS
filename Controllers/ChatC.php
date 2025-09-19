<?php
require_once "Models/Mensaje.php";

class ChatC
{
    // Mostrar la vista de chat
    public function mostrarChat()
    {
        $mensaje = new Mensaje();
        $usuario_id = $_SESSION['id'] ?? null;
        $rol = $_SESSION['rol'] ?? null;

        if (!$usuario_id || !$rol) {
            die("No hay sesión iniciada o faltan datos de usuario.");
        }

        // Verificar si es admin (numérico, no string)
        $esAdmin = ($rol == ROL_ADMIN);

        if ($esAdmin) {
            $mensajes = $mensaje->obtenerTodosLosMensajes() ?? [];
            include "Views/chat_admin.php";
        } else {
            $mensajes = $mensaje->obtenerMensajes($usuario_id) ?? [];
            include "Views/chat.php";
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
     public function enviar() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario_id = $_POST['usuario_id'];
            $mensaje = $_POST['mensaje'];

            $mensajeModel = new Mensaje();
            $mensajeModel->guardarMensaje($usuario_id, $mensaje);
        
            header("Location: index.php?accion=mostrarChat");
            exit;
        }
    }
}
