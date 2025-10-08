<?php
require_once("./Config/conexion.php");

class Producto {
    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

    public function obtenerCategorias(){
        $sql = "SELECT * FROM categoria";
        $resultado = $this->conn->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerCategoriaporId($categoria_id) {
        $categoria_id = (int)$categoria_id;
        $sql = "SELECT nombre FROM categoria WHERE id = $categoria_id LIMIT 1";
        $result = $this->conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            return $row['nombre'];
        }
        return null;
    }

    public function listarP($id_usuario, $orden, $search) {
        $id_usuario = (int)$id_usuario;
        $sql = "SELECT p.*, c.nombre AS categoria_nombre FROM producto p INNER JOIN categoria c ON p.id_cat = c.id WHERE p.id_usuario = ? ";

        $params = [$id_usuario];
        $param_types = 'i';
        if (!empty($search)) {
        $sql .= "AND ";
        $search_terms = explode(" ", $search);
        $conditions = [];

        foreach ($search_terms as $palabra) {
            $conditions[] = "(p.nombre LIKE ? OR c.nombre LIKE ?)";
            $search_term = "%" . $palabra . "%";
            $params[] = $search_term;
            $params[] = $search_term;
            $param_types .= 'ss';
        }
        $sql .= implode(" AND ", $conditions);
        }
        switch ($orden) {
            case "A-Z":
                $sql .= "ORDER BY p.nombre ASC";
                break;
            case "Z-A":
                $sql .= "ORDER BY p.nombre DESC";
                break;
            case "Más Recientes":
                $sql .= "ORDER BY p.id DESC";
                break;
            case "Más Antiguos":
                $sql .= "ORDER BY p.id ASC";
                break;
            default:
                $sql .= "ORDER BY p.id ASC";
                break;
        }
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            error_log("MySQLi Prepare Error: " . $this->conn->error);
            return [];
        }

        $stmt->bind_param($param_types, ...$params);
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

    public function existeProducto($nombre, $id_usuario) {
        $nombre = $this->conn->real_escape_string($nombre);
        $id_usuario = (int)$id_usuario;
        $sql = "SELECT COUNT(*) AS count FROM producto WHERE nombre = '$nombre' AND id_usuario = '$id_usuario'";
        $result = $this->conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['count'] > 0;
        }
        return false;
    }

    public function obtenerProductoPorId($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM producto WHERE id = $id LIMIT 1";
        $result = $this->conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return $row;
        }
        return null;
    }

    public function actualizarProducto($id, $nombre, $imagen, $categoria_id) {
        $id = (int)$id;
        $nombre = $this->conn->real_escape_string($nombre);
        $imagen = $this->conn->real_escape_string($imagen);
        $categoria_id = (int)$categoria_id;

        $sql = "UPDATE producto SET nombre = '$nombre', imagen = '$imagen', id_cat = '$categoria_id' WHERE id = $id";
        return $this->conn->query($sql);
    }

    public function crearP($nombre, $imagen, $categoria_id, $id_usuario) {
    $sql = "INSERT INTO producto (nombre, imagen, id_cat, id_usuario) VALUES (?, ?, ?, ?)";
    
    $stmt = $this->conn->prepare($sql);
    
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("ssii", $nombre, $imagen, $categoria_id, $id_usuario);
    
    if ($stmt->execute()) {
        return $stmt->insert_id;
    } else {
        return false;
    }
}

    public function borrar($id) {
        $sql = "DELETE FROM producto WHERE id=$id";
        return $this->conn->query($sql);
    }
}
?>