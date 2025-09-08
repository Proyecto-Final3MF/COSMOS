<?php
require_once(__DIR__ . '/../Config/conexion.php');

class Mensaje
{
    private $conexion;


    public function __construct()
    {
        $this->conexion = conectar();
    }

    public function obtenerMensaje($receptor_id = null)
    {
        $sql = "SELECT m.*, u.nombre as usuario
                FROM mensaje m
                JOIN usuarios u ON. m.usuario_id = u.id";

        if ($receptor_id !== null) {
            $sql .= "WHERE m.receptor_id = ? OR m.usuario_id = ?";
        }

        $sql .= "ORDER by m.fecha DESC LIMIT 50";

        $stmt = $this->conexion->prepare($sql);

        if ($receptor_id !== null) {
            $stmt->bind_param("li", $receptor_id, $receptor_id);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function enviarMensaje($usuario_id, $receptor_id, $mensaje)
    {
        $sql = "INSERT INTO mensaje (usuario_id, receptor_id, mensaje) VALUE (?,?,?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iis", $usuario_id, $receptor_id, $mensaje);
        return $stmt->execute();
    }
}
