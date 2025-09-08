<?php
require_once "Models/Mensaje.php";

class ChatC {
    public function mostrarChat() {
        $mensaje = new Mensaje();
        $receptor_id = $_GET['receptor'] ?? null;
        $mensaje = $mensaje->obtenerMensajes($receptor_id);

        include "Views/chat.php";
}

public function enviar() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usuario_id = $_POST['usuario_id'];
        $receptor_id = $_POST['receptor_id'] ?? null;
        $texto = $_POST['mensaje'];

        $mensaje = new Mensaje();
        $mensaje->enviarMensaje($usuario_id, $receptorr_id, $texto);
    }
}