<?php
require_once(__DIR__ . '/../Config/conexion.php');

class Mensaje {
    private $conexion;


    public function __construct() {
        $this->conexion = conectar();
    }

    public function obtenerMensaje($receptor_id = null) {
        $sql = "SELECT m.*, u.nombre as usuario
                FROM mensaje m
                JOIN usuarios u ON. m.usuario_id = u.id";

        if ($receptor_id !== null) {
            $sql .= "WHERE m.receptor_id = ? OR m.usuario_id = ?";
        }

        $sql .= "ORDER"
    } 
}
?>