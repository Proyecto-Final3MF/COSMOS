<?php

require_once __DIR__ . '/../Config/conexion.php';

class HistorialModel {
    private $conexion;

    public function __construct() {
        $this->conexion = conectar();
    }

    public function registrarModificacion($usuario_id, $item, $solicitud_id, $obs) {
        $usuario_id_para_db = ($usuario_id === 0 || $usuario_id === null) ? NULL : $usuario_id;

        $query = "INSERT INTO historial (usuario_id, item, item_id, fecha_hora, obs)
                  VALUES (?, ?, ?, NOW(), ?)";

        $stmt = $this->conexion->prepare($query);

        if ($stmt === false) {
            error_log("ERROR: Failed to prepare statement in HistorialModel: " . $this->conexion->error);
            return false;
        }

        // Bind all parameters, including 'item'
        // 'i' for usuario_id, 's' for item, 'i' for solicitud_id, 's' for obs
        $stmt->bind_param("isis", $usuario_id_para_db, $item, $solicitud_id, $obs);

        $success = $stmt->execute();

        if (!$success) {
            error_log("ERROR: Failed to insert into historial. Statement Error: " . $stmt->error);
        }

        $stmt->close();
        return $success;
    }

    public function getHistorial() {
        $historial = [];
        $query = "SELECT h.id, h.usuario_id, u.nombre AS nombre_usuario, h.item, h.item_id, h.fecha_hora, h.obs
                  FROM historial h
                  LEFT JOIN usuario u ON h.usuario_id = u.id
                  ORDER BY h.fecha_hora DESC";
        $resultado = $this->conexion->query($query);

        if ($resultado === false) {
            error_log("ERROR: Query failed in getHistorial: " . $this->conexion->error);
        } else {
            while ($fila = $resultado->fetch_object()) {
                $historial[] = $fila;
            }
            $resultado->free();
        }
        return $historial;
    }

    public function __destruct() {
        if ($this->conexion && $this->conexion->ping()) {
            $this->conexion->close();
        }
    }
}
?>