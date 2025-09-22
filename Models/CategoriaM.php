<?php

class Categoria {

    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

    public function verificarExistencia($nombre) {
        $sql = "SELECT COUNT(*) as count FROM categoria WHERE nombre = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param('s', $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
        $stmt->close();

        return $row['count'] > 0;
    }

    public function guardarC($nombre) {
        $sql = "INSERT INTO categoria (nombre) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param('s', $nombre);
        $result = $stmt->execute();
        $newId = $result ? $this->conn->insert_id : false;

        $stmt->close();
        return $newId;
    }

    public function listarC() {
        $sql = "SELECT * FROM categoria ORDER BY nombre ASC";
        $resultado = $this->conn->query($sql);

        $categorias = [];
        if ($resultado) {
            while ($row = $resultado->fetch_assoc()) {
                $categorias[] = $row;
            }
        }
        return $categorias;
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM categoria WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $categoria = $result->fetch_assoc();
        $stmt->close();

        return $categoria;
    }

    public function actualizarC($id, $nombre) {
        $sql = "UPDATE categoria SET nombre = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("si", $nombre, $id);
        $resultado = $stmt->execute();
        $stmt->close();

        return $resultado;
    }
    
    public function borrarC($id) {
        $sql = "DELETE FROM categoria WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param('i', $id);
        $resultado = $stmt->execute();
        $stmt->close();

        return $resultado;
    }
}
?>
