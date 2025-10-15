<?php
require_once(__DIR__ . '/../Models/NotificacionM.php');

class NotificacionC {
    private $modelo;

    public function __construct() {
        $this->modelo = new NotificacionM();
    }

    // Crear una notificación
    public function crearNotificacion($usuario_id, $mensaje) {
        return $this->modelo->crear($usuario_id, $mensaje);
    }

    // Mostrar todas las no leídas
    public function listarNoLeidas() {
        $usuario_id = $_SESSION['id'] ?? null;
        if (!$usuario_id) return [];

        return $this->modelo->obtenerNoLeidas($usuario_id);
    }

    // Marcar todas como leídas
    public function marcarTodasLeidas() {
        $usuario_id = $_SESSION['id'] ?? null;
        if (!$usuario_id) return false;

        return $this->modelo->marcarTodasLeidas($usuario_id);
    }
}
?>
