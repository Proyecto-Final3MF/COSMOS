<?php
require_once("config/conexion.php");

class Cliente {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }

    public function listar() {
        $sql = "SELECT * FROM cliente";
        return $this->db->query($sql);
    }

    public function guardar($cedula, $nombre) {
        $sql = "INSERT INTO cliente (cedula, nombre) VALUES ($cedula, '$nombre')";
        return $this->db->query($sql);
    }

    public function buscarPorCedula($cedula){
        $sql = "SELECT * FROM cliente WHERE cedula = $cedula";
        return $this->db->query($sql)->fetch_assoc();
    }

    public function actualizar($cedula, $nombre) {
        $sql = "UPDATE cliente SET cedula='$cedula' nombre='$nombre', WHERE cedula='$cedula'";
        return $this->db->query($sql);
    }

    public function borrar($cedula) {
        $sql = "DELETE FROM cliente WHERE cedula=$cedula";
        return $this->db->query($sql);
    }
}

?>