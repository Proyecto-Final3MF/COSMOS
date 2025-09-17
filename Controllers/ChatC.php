<?php
require_once "Models/Mensaje.php";

class ChatC
{
    // Mostrar chat normal
    public function mostrarChat()
    {
        session_start();

        $mensaje = new Mensaje();
        $usuario_id = $_SESSION['id'] ?? null;
        $rol = $_SESSION['rol'] ?? null; //'usuario', 'tecnico' o 'admin'

        if (!$usuario_id || !$rol) {
            die("No hay sesión iniciada o faltan datos de usuario.");
        }

        // Si es admin -> ver todo
        $esAdmin = ($rol === 'admin');

        if ($esAdmin) {
            $mensajes = $mensaje->obtenerTodosLosMensajes() ?? [];
            include "Views/chat_admin.php"; //vista especial
        } else {
            $mensajes = $mensaje->obtenerMensajes($usuario_id) ?? [];
            include "Views/chat.php"; // vista normal
        }
    }

    public function listarMensajes()
    {
        session_start();
        $mensaje = new Mensaje();
        $usuario_id = $_SESSION['id'] ?? null;
        $rol = $_SESSION['rol'] ?? null;
        $esAdmin = ($rol === 'admin');

        if (!$usuario_id) {
            http_response_code(401);
            exit("No autorizado");
        }

        $mensajes = $mensaje->obtenerMensajes($usuario_id, $esAdmin);

        foreach ($mensajes as $m) {
            echo "<p><strong>" . htmlspecialchars($m['usuario']) . ":</strong>" .
                nl2br(htmlspecialchars($m['mensaje'])) . "</p>";
        }
    }

    public function enviar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario_id = $_POST['usuario_id'] ?? null;
            $receptor_id = $_POST['receptor_id'] ?? null;
            $texto = $_POST['mensaje'] ?? '';

            if (!$usuario_id || !$texto) {
                die("Datos incompletos para enviar el mensaje.");
            }

            $mensaje = new Mensaje();
            $mensaje->enviarMensaje($usuario_id, $receptor_id, $texto);
        }
    }
}
