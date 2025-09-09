<?php
require_once "Models/Mensaje.php";

class ChatC
{
    // Mostrar chat normal
    public function mostrarChat()
    {
        $mensaje = new Mensaje();
        $usuario_id = $_SESSION['id'];
        $rol = $_SESSION['rol']; //'usuario', 'tecnico' o 'admin'

        // Si es admin -> ver todo
        $esAdmin = ($rol === 'admin');

        $mensajes = $mensaje->obtenerMensajes($usuario_id, $esAdmin);

        if ($esAdmin) {
            include "Views/chat_admin.php"; //vista especial
        } else {
            include "Views/chat.php"; // vista normal
        }
    }

    public function enviar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario_id = $_POST['usuario_id'];
            $receptor_id = $_POST['receptor_id'] ?? null;
            $texto = $_POST['mensaje'];

            $mensaje = new Mensaje();
            $mensaje->enviarMensaje($usuario_id, $receptor_id, $texto);
        }
    }
}
