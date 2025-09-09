<?php
require_once(__DIR__ . '/../Config/conexion.php');

class Mensaje
{
    private $conexion;


    public function __construct()
    {
        $this->conexion = conectar(); // funcion global que conecta a la DB
    }

    public function obtenerMensajes($receptor_id = null, $esAdmin = false)
    {
        if ($esAdmin) {
            // Si es admin -> ver todos los mensajes
            $sql = "SELECT m.*, u.nombre as usuario, r.nombre as receptor
                    FROM mensajes m
                    JOIN usuarios u ON m.usuario_id = u.id
                    LEFT JOIN usuarios r ON m.receptor_id = r.id
                    ORDER BY m.fecha DESC";
            $stmt = $this->conexion->prepare($sql);
        } else {
            // Usuario normal -> solo ve sus mensajes
            $sql = "SELECT m.*, u.nombre as usuario
                    FROM mensajes m
                    JOIN usuarios u ON m.usuario_id = u.id
                    WHERE m.receptor_id = ? OR m.usuario_id = ?
                    ORDER BY m.fecha DESC";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ii", $receptor_id, $receptor_id);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Enviar mensaje
    public function enviarMensaje($usuario_id, $receptor_id, $mensaje)
    {
        $sql = "INSERT INTO mensaje (usuario_id, receptor_id, mensaje) VALUE (?,?,?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iis", $usuario_id, $receptor_id, $mensaje);
        return $stmt->execute();
    }
}
