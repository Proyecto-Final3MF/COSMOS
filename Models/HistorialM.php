<?php

require_once(__DIR__ . '/../config/conexion.php');



class HistorialM {
    private $conexion;

    public function __construct() {
        $this->conexion = conectar();
    }
    
    public function registrarModificacion($usuario_id, $nombre_usuario, $accion, $item, $item_id, $obs) {
        $usuario_id_para_db = ($usuario_id === 0 || $usuario_id === null) ? NULL : $usuario_id;

        $query = "INSERT INTO historial (usuario, usuario_id, accion, item, item_id, fecha_hora, obs)
                 VALUES (?, ?, ?, ?, ?, NOW(), ?)";

        $stmt = $this->conexion->prepare($query);

        if ($stmt === false) {
            error_log("ERROR: Failed to prepare statement in HistorialModel: " . $this->conexion->error);
            return false;
        }

        $stmt->bind_param("sissis", $nombre_usuario, $usuario_id_para_db, $accion, $item, $item_id, $obs);

        $success = $stmt->execute();

        if (!$success) {
            error_log("ERROR: Failed to insert into historial. Statement Error: " . $stmt->error);
        }

        $stmt->close();
        return $success;
    }

    public function getHistorial() {
        $historial = [];
        $query = "SELECT h.id, h.usuario_id, h.usuario, h.accion, h.item, h.item_id, h.fecha_hora, h.obs
                 FROM historial h
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
