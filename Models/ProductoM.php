<?php
require_once("./Config/conexion.php");

class Producto {
    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

     public function obtenerCategorias(){
        $sql = "SELECT * FROM producto";
        $resultado = $this->conn->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerCategoriaporId($categoria_id) {
        $categoria_id = (int)$categoria_id;
        $sql = "SELECT nombre FROM producto WHERE id = $categoria_id LIMIT 1";
        $result = $this->conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            return $row['nombre'];
        }
        return null;
    }

    public function crearP($categoria_id, $nombre, $producto) {
        $usuario = $this->conn->real_escape_string($categoria_id);
        $mail = $this->conn->real_escape_string($nombre);
        $contrasena = $this->conn->real_escape_string($producto);
        
        $sql = "INSERT INTO usuario () VALUES ()";
        return $this-conn->query($sql);
    }
}
?>