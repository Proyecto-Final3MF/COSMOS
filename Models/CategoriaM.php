<?php

class Categoria {

    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

    public function verificarExistencia($nombre) {
        $sql = "SELECT COUNT(*) as count FROM categoria WHERE nombre = ?";
        
        $stmt = $this->conn->prepare($sql); 
        
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
        $stmt->bind_param('s', $nombre);
        $result = $stmt->execute();
        
        $stmt->close();
        
        return $result;
    }

    public function listarC() {
        $sql = "SELECT * FROM categoria";
        return $this->conn->query($sql);
    }

    public function buscarPorId($id) {
    $sql = "SELECT * FROM categoria WHERE id = ?";
    
    $stmt = $this->conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

    public function actualizarC($id, $nombre) {
        $sql = "UPDATE categoria SET nombre = ? WHERE id = ?";
    
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt) {
            $stmt->bind_param("si", $nombre, $id);
        
            $resultado = $stmt->execute();
        
            $stmt->close();
        
            return $resultado;
        } else {
            return false;
        }
    }
}
?>