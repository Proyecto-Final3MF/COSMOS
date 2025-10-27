<?php

require_once(__DIR__ . '/../Config/conexion.php');

class HistoriaM {
    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

    public function registrarEvento($id_solicitud, $evento) {

        $query = "INSERT INTO historia_solicitud (id_solicitud, evento, fecha_hora) VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            error_log("ERROR: Failed to prepare statement in HistoriaM: " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("is", $id_solicitud, $evento);

        $success = $stmt->execute();

        if (!$success) {
            error_log("ERROR: Failed to insert into historia. Statement Error: " . $stmt->error);
        }

        $stmt->close();
        return $success;
    }

    public function mostrarHistoria($id_solicitud) {
        $id_solicitud = (int)$id_solicitud;

        $sql = "SELECT * FROM historia_solicitud WHERE id_solicitud = ?";
        
        $stmt = $this->conn->prepare($sql);
            
        if (!$stmt) {
            error_log("MySQLi Prepare Error: " . $this->conn->error);
            return [];
        }

        if (!empty($id_solicitud)) {
            $stmt->bind_param('i', $id_solicitud);
        }
            
        $success = $stmt->execute();
            
        if ($success) {
            $resultado = $stmt->get_result();
            $data = $resultado->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
                    
            return $data;
        } else {
            error_log("MySQLi Execute Error: " . $stmt->error);
            $stmt->close();
            return [];
        }
    }
}