<?php
require_once("config/conexion.php");

class Solicitud {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }

    public function guardar($usuario_id, $imagen, $categoria_id, $obs) {
        $sql = "INSERT INTO solicitud (usuario_id, imagen, categoria_id, obs) VALUES ('$usuario_id, $imagen, $categoria_id, $obs')";
        return $this->db->query($sql);
    }
    
    public function buscarPorId($id){
        $sql = "SELECT * FROM solicitud WHERE id = $id";
        return $this->db->query($sql)->fetch_assoc();
    }

    public function actualizar($id, $imagen, $categoria_id, $obs) {
        $sql = "UPDATE solicitud SET imagen='$imagen' categoria_id='$categoria_id' obs='$obs', WHERE id='$id'";
        return $this->db->query($sql);
    }

    public function borrar($id) {
        $sql = "DELETE FROM solicitud WHERE id=$id";
        return $this->db->query($sql);
    }
}

?>