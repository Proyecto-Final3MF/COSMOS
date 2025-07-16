<?php
require_once(__DIR__ . '/../config/conexion.php');

class Solicitud {
    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

    public function getSolicitudesDisponibles() {
        $sql = "SELECT solicitud.id, solicitud.obs AS obs, estado.nombre AS estado
                FROM solicitud
                JOIN estado ON solicitud.estado_id = estado.id
                WHERE solicitud.estado_id = 1";
        $resultado = $this->conn->query($sql);

        if (!$resultado) {
            error_log("Error en la consulta getSolicitudesDisponibles: " . $this->conn->error);
            return [];
        }

        $solicitudes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $solicitudes[] = $fila;
        }
        return $solicitudes;
    }

    public function getSolicitudesOcupadas($estado_filter = 'all') {
        $sql = "SELECT solicitud.id, solicitud.obs AS obs, estado.nombre AS estado
                FROM solicitud
                JOIN estado ON solicitud.estado_id = estado.id";

        if ($estado_filter === 'all') {
            $sql .= " WHERE solicitud.estado_id != 1";
        } else {
            $filter_id = (int)$estado_filter;
            $sql .= " WHERE solicitud.estado_id = ?";
        }

        $stmt = $this->conn->prepare($sql);

        if ($estado_filter !== 'all') {
            $stmt->bind_param("i", $filter_id);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();

        if (!$resultado) {
            error_log("Error en la consulta getSolicitudesOcupadas: " . $this->conn->error);
            return [];
        }

        $solicitudes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $solicitudes[] = $fila;
        }
        $stmt->close();
        return $solicitudes;
    }

    public function updateSolicitudEstado($solicitudId, $newEstadoId) {
        $sql = "UPDATE solicitud SET estado_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $newEstadoId, $solicitudId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function __destruct() {
       
    }
}
?>