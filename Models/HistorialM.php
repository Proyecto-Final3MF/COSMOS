<?php

require_once(__DIR__ . '/../Config/conexion.php');

class HistorialM {
    private $conexion;

    public function __construct() {
        $this->conexion = conectar();
    }
    
    public function registrarModificacion($usuario, $usuario_id, $accion, $item, $item_id, $obs) {
        $usuario_id_para_db = ($usuario_id === 0 || $usuario_id === null) ? NULL : $usuario_id;

        $query = "INSERT INTO historial (usuario, usuario_id, accion, item, item_id, fecha_hora, obs)
                  VALUES (?, ?, ?, ?, ?, NOW(), ?)";
        $stmt = $this->conexion->prepare($query);

        if ($stmt === false) {
            error_log("ERROR: Failed to prepare statement in HistorialModel: " . $this->conexion->error);
            return false;
        }

        $stmt->bind_param("sissis", $usuario, $usuario_id_para_db, $accion, $item, $item_id, $obs);

        $success = $stmt->execute();

        if (!$success) {
            error_log("ERROR: Failed to insert into historial. Statement Error: " . $stmt->error);
        }

        $stmt->close();
        return $success;
    }

    public function getHistorial($search = null, $startDate = null, $endDate = null) {
    $historial = [];

    $query = "SELECT h.id, h.usuario_id, h.usuario, h.accion, h.item, h.item_id, h.fecha_hora, h.obs FROM historial h";

    $conditions = [];
    $params = [];
    $param_types = '';

    if (!empty($search)) {
        $conditions[] = "(h.usuario LIKE ? OR h.accion LIKE ? OR h.item LIKE ? OR h.obs LIKE ?)";
        $search_term = "%" . $search . "%";
        $params[] = $search_term;
        $params[] = $search_term;
        $params[] = $search_term;
        $params[] = $search_term;
        $param_types .= 'ssss';
    }

    if (!empty($startDate)) {
        if (!empty($endDate)) {
            $conditions[] = "(h.fecha_hora BETWEEN ? AND ?)";
            $params[] = $startDate . ' 00:00:00';
            $params[] = $endDate . ' 23:59:59';
            $param_types .= 'ss';
        } else {
            $endDate = date('d-m-y');
            $conditions[] = "(h.fecha_hora BETWEEN ? AND ?)";
            $params[] = $startDate . ' 00:00:00';
            $params[] = $endDate . ' 23:59:59';
            $param_types .= 'ss';
        }
    }

    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    $query .= " ORDER BY h.fecha_hora DESC";

    $stmt = $this->conexion->prepare($query);

    if ($stmt === false) {
        error_log("ERROR: La declaración preparada falló en getHistorial: " . $this->conexion->error);
        return [];
    }

    if (!empty($params)) {
        $stmt->bind_param($param_types, ...$params);
    }

    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado === false) {
        error_log("ERROR: get_result fallo en getHistorial: " . $stmt->error);
    } else {
        while ($fila = $resultado->fetch_object()) {
            $historial[] = $fila;
        }
        $resultado->free();
    }

    $stmt->close();
    return $historial;
}

    public function __destruct() {
        if ($this->conexion && $this->conexion->ping()) {
            $this->conexion->close();
        }
    }
}
?>
