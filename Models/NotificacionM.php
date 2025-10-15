<?php
require_once(__DIR__ . '/../Config/conexion.php');

class NotificacionM {
    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

    // Crear notificación
    public function crear($usuario_id, $mensaje) {
        $sql = "INSERT INTO notificacion (usuario_id, mensaje) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $usuario_id, $mensaje);
        return $stmt->execute();
    }

    // Obtener notificaciones no leídas
    public function obtenerNoLeidas($usuario_id) {
        $sql = "SELECT * FROM notificacion WHERE usuario_id = ? AND leida = 0 ORDER BY fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Marcar como leída
    public function marcarLeida($id) {
        $sql = "UPDATE notificacion SET leida = 1 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Marcar todas como leídas
    public function marcarTodasLeidas($usuario_id) {
        $sql = "UPDATE notificacion SET leida = 1 WHERE usuario_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        return $stmt->execute();
    }
}
?>
