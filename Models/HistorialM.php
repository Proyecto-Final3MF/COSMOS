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

    public function getHistorial(?string $nombre = null, ?int $id_usuario = null, ?string $fecha_1 = null, ?string $fecha_2 = null): array
{
    $historial = [];
    $sql = "SELECT h.id, h.usuario_id, h.usuario, h.accion, h.item, h.item_id, h.fecha_hora, h.obs FROM historial h";
    
    $condicoes = [];
    $params = [];
    $param_types = '';
    if ($nombre_user !== null) {
        $condicoes[] = "h.usuario = ?";
        $params[] = $nombre_user;
        $param_types .= 's';
    }
    if ($id_usuario !== null) {
        $condicoes[] = "h.usuario_id = ?";
        $params[] = $id_usuario;
        $param_types .= 'i';
    }
    
    if ($nombre_item !== null) {
        $condicoes[] = "h.usuario = ?";
        $params[] = $nombre_item;
        $param_types .= 's';
    }
    if ($id_item !== null) {
        $condicoes[] = "h.usuario_id = ?";
        $params[] = $id_item;
        $param_types .= 'i';
    }
    if ($fecha_1 !== null && $fecha_2 !== null) {
        $condicoes[] = "h.fecha_hora BETWEEN ? AND ?";
        $params[] = $fecha_1;
        $params[] = $fecha_2;
        $param_types .= 'ss';
    }
    
    if (!empty($condicoes)) {
        $sql .= " WHERE " . implode(" AND ", $condicoes);
    }
    
    $sql .= " ORDER BY h.fecha_hora DESC";
    
    $stmt = $this->conn->prepare($sql);
    
    if ($stmt === false) {
        error_log("MySQLi Prepare Error: " . $this->conn->error . " | SQL: " . $sql);
        throw new mysqli_sql_exception("Failed to prepare statement: " . $this->conn->error);
    }
    
    if (!empty($params)) {
        $stmt->bind_param($param_types, ...$params);
    }
    
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado === false) {
        error_log("ERROR: Query failed in getHistorial: " . $stmt->error);
        return [];
    }
    
    while ($fila = $resultado->fetch_object()) {
        $historial[] = $fila;
    }
    
    $resultado->free();
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
