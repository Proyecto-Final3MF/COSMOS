<?php
class Review {
    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

   public function agarrarCantReview ($id_tecnico) {
        $sql = "SELECT cant_review FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("MySQLi Prepare Error: " . $this->conn->error);
            return null; 
        }

        $stmt->bind_param("i", $id_tecnico);

        if (!$stmt->execute()) {
            error_log("MySQLi Execute Error: " . $stmt->error);
            $stmt->close();
            return null;
        }

        $resultado = $stmt->get_result();
        $data = $resultado->fetch_assoc();
        $stmt->close();
        return $data['cant_review'] ?? null;
    }

    public function agarrarPromedio($id_tecnico) {
        $sql = "SELECT promedio FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("MySQLi Prepare Error: " . $this->conn->error);
            return null; 
        }

        $stmt->bind_param("i", $id_tecnico);

        if (!$stmt->execute()) {
            error_log("MySQLi Execute Error: " . $stmt->error);
            $stmt->close();
            return null;
        }

        $resultado = $stmt->get_result();
        $data = $resultado->fetch_assoc();
        $stmt->close();
        return $data['promedio'] ?? null;
    }

    public function AddReview($suma_rating, $CantReview, $ratingPromedio, $rating, $id_tecnico, $id_cliente, $Comentario, $id_solicitud) {
        $sql1 = "UPDATE usuario SET cant_review = ?, promedio = ?, suma_rating = ? WHERE id = ?";
        
        // Preparar la sentencia
        if ($stmt1 = $this->conn->prepare($sql1)) {
            $stmt1->bind_param("iddi", $CantReview, $ratingPromedio, $suma_rating, $id_tecnico); 
            
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

        $sql2 = "INSERT INTO reviews (id_solicitud, id_tecnico, id_cliente, rating, comentario) VALUES (?, ?, ?, ?, ?)";
        
        // Preparar la sentencia
        if ($stmt2 = $this->conn->prepare($sql2)) {
            $stmt2->bind_param("iiids", $id_solicitud, $id_tecnico, $id_cliente, $rating, $Comentario);
        
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

    public function YaCalificado($id) {
        $sql = "SELECT * FROM reviews WHERE id_solicitud = ?";
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt === false) {
            error_log("Prepare failed: " . $this->conn->error);
            return null;
        }
        
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result(); 

            if ($resultado && $resultado->num_rows > 0) {
                return $resultado->fetch_assoc();
            } else {
                return null;
            }
        } else {
            error_log("Execute failed: " . $stmt->error);
            return null;
        }
    }

    public function updateReview($suma_rating, $ratingPromedio, $rating, $Comentario, $id_solicitud, $id_tecnico, $CantReview) {
        $sql1 = "UPDATE usuario SET cant_review = ?, promedio = ?, suma_rating = ? WHERE id = ?";
        
        // Preparar la sentencia
        if ($stmt1 = $this->conn->prepare($sql1)) {
            $stmt1->bind_param("iddi", $CantReview, $ratingPromedio, $suma_rating, $id_tecnico); 
            
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

        $sql2 = "UPDATE reviews SET rating = ?, comentario = ? WHERE id_solicitud = ?";

        if ($stmt2 = $this->conn->prepare($sql2)) {
            $stmt2->bind_param("dsi", $rating, $Comentario, $id_solicitud);
        
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

    public function listarReviewsTecnico($id_tecnico) {
        $sql = "SELECT r.*, u.nombre as cliente FROM reviews r INNER JOIN usuario u ON r.id_cliente = u.id WHERE id_tecnico = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_tecnico);

        if (!$stmt) {
            error_log("MySQLi Prepare Error: " . $this->conn->error);
            return [];
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

    public function agarrarSuma($id_tecnico) {
        $sql = "SELECT suma_rating FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("MySQLi Prepare Error: " . $this->conn->error);
            return null; 
        }

        $stmt->bind_param("i", $id_tecnico);

        if (!$stmt->execute()) {
            error_log("MySQLi Execute Error: " . $stmt->error);
            $stmt->close();
            return null;
        }

        $resultado = $stmt->get_result();
        $data = $resultado->fetch_assoc();
        $stmt->close();
        return $data['suma_rating'] ?? null; 
    }

    public function checkUsuario($id_solicitud, $id_usuario) {
        $sql = "SELECT id FROM solicitud WHERE id = ? AND cliente_id = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param("ii", $id_solicitud, $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
.
        if ($resultado->num_rows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
}