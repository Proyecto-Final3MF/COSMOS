<?php
class Usuario {
    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

    public function agarrarCantReview () {
        $sql = "SELECT cant_review FROM usuario WHERE id = $id_tecnico";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $estado_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc(); 
    }
    public function agarrarPromedio() {
        $sql = "SELECT promedio FROM usuario WHERE id = $id_tecnico";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $estado_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
// Asumiendo que esta función es parte de una clase que tiene acceso a la conexión a la base de datos.
    public function AddReview($CantReview, $NotaPromedio, $Nota, $id_tecnico, $id_cliente) {
        // 1. Obtener la conexión a la base de datos (adaptar según tu clase)

        $sql1 = "UPDATE usuario SET cant_review = ?, promedio = ? WHERE id = ?";
        
        // Preparar la sentencia
        if ($stmt1 = $conn->prepare($sql1)) {
            $stmt1->bind_param("idi", $CantReview, $NotaPromedio, $id_tecnico); 
            
            // Ejecutar
            if (!$stmt1->execute()) {
                // Manejo de error
                error_log("Error al ejecutar UPDATE en usuario: " . $stmt1->error);
                $stmt1->close();
                return false;
            }
            $stmt1->close();
        } else {
            error_log("Error al preparar la sentencia SQL1: " . $conn->error);
            return false;
        }

        $sql2 = "INSERT INTO reviews (id_tecnico, id_cliente, nota) VALUES (?, ?, ?)";
        
        // Preparar la sentencia
        if ($stmt2 = $conn->prepare($sql2)) {
            $stmt2->bind_param("iid", $id_tecnico, $id_cliente, $Nota);
        
            if (!$stmt2->execute()) {
                error_log("Error al ejecutar INSERT en reviews: " . $stmt2->error);
                $stmt2->close();
                return false;
            }
            $stmt2->close();
        } else {
            error_log("Error al preparar la sentencia SQL2: " . $conn->error);
            return false;
        }

        return true;
    }
}