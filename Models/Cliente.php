<?php
require_once(__DIR__ . "/../config/conexion.php");

class Cliente {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }

    public function guardar($nombre) {
        $sql = "INSERT INTO cliente (nombre) VALUES ('$nombre')";
        return $this->db->query($sql);
    }

    public function buscarPorId($id){
        $sql = "SELECT * FROM cliente WHERE id = $id";
        return $this->db->query($sql)->fetch_assoc();
    }

    public function actualizar($id, $nombre) {
        $sql = "UPDATE cliente SET nombre='$nombre', WHERE id='$id'";
        return $this->db->query($sql);
    }

    public function borrar($id) {
        $sql = "DELETE FROM cliente WHERE id=$id";
        return $this->db->query($sql);
    }
}

?>