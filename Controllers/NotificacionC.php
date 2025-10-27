<?php
require_once(__DIR__ . '/../Models/NotificacionM.php');

class NotificacionC {
    private $modelo;

    public function __construct() {
        $this->modelo = new NotificacionM();
    }

    // Crear una notificación (agregamos $tipo)
    public function crearNotificacion($usuario_id, $mensaje, $tipo = 'normal') {
        return $this->modelo->crear($usuario_id, $mensaje, $tipo);
    }

    // Mostrar todas las no leídas (opcional: por tipo)
    public function listarNoLeidas($tipo = null) {
        $usuario_id = $_SESSION['id'] ?? null;
        if (!$usuario_id) return [];
        return $this->modelo->obtenerNoLeidas($usuario_id, $tipo);
    }

    // Marcar todas como leídas (opcional: por tipo)
    public function marcarTodasLeidas($tipo = null) {
        $usuario_id = $_SESSION['id'] ?? null;
        if (!$usuario_id) return false;
        return $this->modelo->marcarTodasLeidas($usuario_id, $tipo);
    }
}
?>