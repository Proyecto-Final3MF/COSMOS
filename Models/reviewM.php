<?php
class Review {
    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

    public function agarrarCantReview () {
        $sql = "SELECT cant_review FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_tecnico);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc(); 
    }
    public function agarrarPromedio() {
        $sql = "SELECT promedio FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_tecnico);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
// Asumiendo que esta función es parte de una clase que tiene acceso a la conexión a la base de datos.
    public function AddReview($CantReview, $ratingPromedio, $rating, $id_tecnico, $id_cliente, $comentario) {
        // 1. Obtener la conexión a la base de datos (adaptar según tu clase)

        $sql1 = "UPDATE usuario SET cant_review = ?, promedio = ? WHERE id = ?";
        
        // Preparar la sentencia
        if ($stmt1 = $conn->prepare($sql1)) {
            $stmt1->bind_param("idi", $CantReview, $ratingPromedio, $id_tecnico); 
            
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

        $sql2 = "INSERT INTO reviews (id_tecnico, id_cliente, rating, comentario) VALUES (?, ?, ?, ?)";
        
        // Preparar la sentencia
        if ($stmt2 = $conn->prepare($sql2)) {
            $stmt2->bind_param("iids", $id_tecnico, $id_cliente, $rating, $Comentario);
        
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