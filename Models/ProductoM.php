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

    public function listarP($id_usuario) {
        $id_usuario = (int)$id_usuario;
        $sql = "SELECT * FROM producto WHERE id_usuario = $id_usuario";
        $resultado = $this->conn->query($sql);
        
        if ($resultado) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
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

    public function crearP($nombre, $imagen, $categoria_id, $id_usuario) {
        $nombre = $this->conn->real_escape_string($nombre);
        $imagen = $this->conn->real_escape_string($imagen);
        $categoria_id = (int)$categoria_id;
        $id_usuario = (int)$id_usuario;

        $sql = "INSERT INTO producto (nombre, imagen, id_cat, id_usuario) VALUES ('$nombre', '$imagen', '$categoria_id', '$id_usuario')";
        return $this->conn->query($sql);
    }

    public function borrar($id) {
        $sql = "DELETE FROM producto WHERE id=$id";
        return $this->conn->query($sql);
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

    $sql = "UPDATE producto SET nombre = '$nombre', imagen = '$imagen', id_cat = $categoria_id WHERE id = $id";
    return $this->conn->query($sql);
}
    }
    ?>