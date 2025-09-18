<?php
require_once(__DIR__ . '/../Config/conexion.php');

class Mensaje
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = new mysqli('localhost', 'root', '', 'basedatos');
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function obtenerMensajes($receptor_id = null, $esAdmin = false)
    {
        if ($esAdmin) {
            // Si es admin -> ver todos los mensajes
            $sql = "SELECT m.id, m.usuario_id, m.receptor_id, m.mensaje, m.fecha,
                    u.nombre AS usuario, r.nombre AS receptor
                    FROM mensajes m
                    JOIN usuarios u ON m.usuario_id = u.id
                    LEFT JOIN usuarios r ON m.receptor_id = r.id
                    ORDER BY m.fecha DESC";
            $stmt = $this->conexion->prepare($sql);
        } else {
            // Usuario normal -> solo ve sus mensajes
            $sql = "SELECT m.id, m.usuario_id, m.receptor_id, m.mensaje, m.fecha,
                    u.nombre AS usuario
                    FROM mensajes m
                    JOIN usuarios u ON m.usuario_id = u.id
                    WHERE m.receptor_id = ? OR m.usuario_id = ?
                    ORDER BY m.fecha DESC";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ii", $receptor_id, $receptor_id);
        }

        if (!$stmt) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function obtenerTodosLosMensajes()
    {
        $sql = "SELECT m.id, m.usuario_id, m.receptor_id, m.mensaje, m.fecha, 
                u.nombre AS usuario, r.nombre AS receptor
                FROM mensajes m 
                JOIN usuarios u ON m.usuario_id = u.id 
                LEFT JOIN usuarios r ON m.receptor_id = r.id
                ORDER BY m.fecha ASC";

        $result = $this->conexion->query($sql);

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Enviar mensaje
    public function enviarMensaje($usuario_id, $receptor_id, $mensaje)
    {
        $sql = "INSERT INTO mensajes (usuario_id, receptor_id, mensaje) VALUES (?,?,?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("iis", $usuario_id, $receptor_id, $mensaje);
        return $stmt->execute();
    }
}
