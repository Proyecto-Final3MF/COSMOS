<?php
require_once(__DIR__ . '/../Config/conexion.php');

class Mensaje
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = new mysqli('localhost', 'root', '', 'tecnicosasociados');
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function obtenerMensajes($usuarioId, $otroUsuarioId)
    {
        if ($otroUsuarioId === null) {
            // solo traer mensajes del usuario
            $sql = "SELECT m.id, m.usuario_id, m.receptor_id, m.mensaje, m.fecha,
                    u.nombre AS usuario
                    FROM mensaje m
                    JOIN usuario u ON m.usuario_id = u.id
                    WHERE m.usuario_id = ?
                    ORDER BY m.fecha DESC";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $usuarioId);
        } else {
            // Mensajes entre usuario y otroUsuario
            $sql = "SELECT m.id, m.usuario_id, m.receptor_id, m.mensaje, m.fecha,
                    u.nombre AS usuario
                    FROM mensaje m
                    JOIN usuario u ON m.usuario_id = u.id
                    WHERE (m.usuario_id = ? AND m.receptor_id = ?)
                    OR (m.usuario_id = ? AND m.receptor_id = ?)
                    ORDER BY m.fecha ASC";

            $stmt = $this->conexion->prepare($sql);
            // Se enlaza el ID del usuario dos veces
            $stmt->bind_param("iiii", $usuarioId, $otroUsuarioId, $otroUsuarioId, $usuarioId);
        }

        // Ejecuta la consulta
        $stmt->execute();
        $result = $stmt->get_result();
        // Devuelve todos los resultados como array asociativo
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    // Obtener conversación entre dos usuarios específicos
    public function obtenerConversacion($usuario_id, $otro_usuario_id)
    {
        // Si es admin -> ver todos los mensajes
        $sql = "SELECT m.id, m.usuario_id, m.receptor_id, m.mensaje, m.fecha,
                u.nombre AS emisor, r.nombre AS receptor
                FROM mensaje m
                JOIN usuario u ON m.usuario_id = u.id
                LEFT JOIN usuario r ON m.receptor_id = r.id
                WHERE (m.usuario_id= ? AND m.receptor_id = ?)
                OR (m.usuario_id = ? AND m.receptor_id = ?)
                ORDER BY m.fecha ASC";

        $stmt = $this->conexion->prepare($sql);
        // Se enlazan los dos IDs en ambas posiciones para cubrir emisor y receptor
        $stmt->bind_param("iiii", $usuario_id, $otro_usuario_id, $otro_usuario_id, $usuario_id);


        $stmt->execute();
        $result = $stmt->get_result();

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    // Obtener lista de conversaciones de un usuario
    public function obtenerConversaciones($usuario_id)
    {
        $sql = "SELECT 
                CASE 
                    WHEN m.usuario_id = ? THEN m.receptor_id 
                    ELSE m.usuario_id 
                END AS otro_usuario_id,
                CASE 
                    WHEN m.usuario_id = ? THEN r.nombre
                    ELSE u.nombre
                END AS otro_usuario,
                SUBSTRING_INDEX(GROUP_CONCAT(m.mensaje ORDER BY m.fecha DESC SEPARATOR '||'), '||', 1) AS ultimo_mensaje,
                MAX(m.fecha) AS ultima_fecha
            FROM mensaje m
            JOIN usuario u ON m.usuario_id = u.id
            JOIN usuario r ON m.receptor_id = r.id
            WHERE m.usuario_id = ? OR m.receptor_id = ?
            GROUP BY otro_usuario_id
            ORDER BY ultima_fecha DESC";

        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            echo "Error en prepare: " . $this->conexion->error;
            return [];
        }

        // Enlazamos 4 veces el mismo ID porque se usa en todas las condiciones
        $stmt->bind_param("iiii", $usuario_id, $usuario_id, $usuario_id, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();

        return $data;
    }

    public function asegurarConversacion($usuario_id, $receptor_id)
    {
        // Verificar si ya existe algun mensaje entre ambos.
        $sql = "SELECT COUNT (*) AS total FROM mensaje
                WHERE (usuario_id = ? AND receptor_id = ?)
                OR (usuario_id = ? AND receptor_id = ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iiii", $usuario_id, $receptor_id, $receptor_id, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        // Si no hay mensajes, crear un mensaje inicial vacio.
        if ($result['total'] === 0) {
            $sql = "INSERT INTO mensaje (usuario_id, receptor_id, mensaje, fecha)
                    VALUES (?, ?, 'Chat iniciado', NOW())";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ii", $usuario_id, $receptor_id);
            $stmt->execute();
        }
    }
        $sql = "SELECT CASE WHEN m.usuario_id = ? THEN m.receptor_id ELSE m.usuario_id END AS otro_usuario_id,
                u.nombre AS otro_usuario,
                MAX(m.fecha) AS ultima_fecha,
                SUBSTRING_INDEX(GROUP_CONCAT(m.mensaje ORDER BY m.fecha DESC SEPARATOR '|||'), '|||', 1) AS ultimo_mensaje
                FROM mensaje m JOIN usuario u
                ON u.id = CASE WHEN m.usuario_id = ? THEN m.receptor_id ELSE m.usuario_id END
                WHERE m.usuario_id = ? OR m.receptor_id = ?
                GROUP BY otro_usuario_id, u.nombre ORDER BY ultima_fecha DESC";

        $stmt = $this->conexion->prepare($sql);
        // Se enlaza el mismo ID 4 veces porque se usa en varias condiciones
        $stmt->bind_param("iiii", $usuario_id, $usuario_id, $usuario_id, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
        $sql = "SELECT CASE WHEN m.usuario_id = ? THEN m.receptor_id ELSE m.usuario_id END AS otro_usuario_id,
                u.nombre AS otro_usuario,
                MAX(m.fecha) AS ultima_fecha,
                SUBSTRING_INDEX(GROUP_CONCAT(m.mensaje ORDER BY m.fecha DESC SEPARATOR '|||'), '|||', 1) AS ultimo_mensaje
                FROM mensaje m JOIN usuario u
                ON u.id = CASE WHEN m.usuario_id = ? THEN m.receptor_id ELSE m.usuario_id END
                WHERE m.usuario_id = ? OR m.receptor_id = ?
                GROUP BY otro_usuario_id, u.nombre ORDER BY ultima_fecha DESC";

        $stmt = $this->conexion->prepare($sql);
        // Se enlaza el mismo ID 4 veces porque se usa en varias condiciones
        $stmt->bind_param("iiii", $usuario_id, $usuario_id, $usuario_id, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    // Obtener todos los mensajes
    public function obtenerTodosLosMensajes()
    {
        $sql = "SELECT m.id, m.usuario_id, m.receptor_id, m.mensaje, m.fecha, 
                u.nombre AS usuario, r.nombre AS receptor
                FROM mensaje m 
                JOIN usuario u ON m.usuario_id = u.id 
                LEFT JOIN usuario r ON m.receptor_id = r.id
                ORDER BY m.fecha ASC";

        $result = $this->conexion->query($sql);

        if (!$result) {
            echo "Error en query: " . $this->conexion->error;
            return [];
        }
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function obtenerTodasLasConversaciones()
    {
        $sql = "SELECT LEAST(usuario_id, receptor_id) AS u1,
                GREATEST(usuario_id, receptor_id) AS u2,
                COUNT(*) AS total_mensajes,
                MAX(fecha) AS ultima_fecha FROM mensaje WHERE receptor_id IS NOT NULL
                GROUP BY u1, u2 ORDER BY ultima_fecha DESC;";

        $result = $this->conexion->query($sql);

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Enviar mensaje
    public function enviarMensaje($usuario_id, $receptor_id, $mensaje)
    {
        if (empty($receptor_id)) {
            $sql = "INSERT INTO mensaje (usuario_id, receptor_id, mensaje) VALUES (?,NULL,?)";
            $stmt = $this->conexion->prepare($sql);
            if (!$stmt) {
                return false;
            }
            $stmt->bind_param("is", $usuario_id, $mensaje);
        } else {
            // Mensaje dirigido a un receptor
            $sql = "INSERT INTO mensaje (usuario_id, receptor_id, mensaje) VALUES (?,?,?)";
            $stmt = $this->conexion->prepare($sql);
            if (!$stmt) {
                return false;
            }
            $stmt->bind_param("iis", $usuario_id, $receptor_id, $mensaje);
        }
        return $stmt->execute();
    }
    // Guardar mensaje sin receptor
    public function guardarMensaje($usuario_id, $mensaje)
    {
        $sql = "INSERT INTO mensaje (usuario_id, mensaje) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("is", $usuario_id, $mensaje);
        $stmt->execute();
        $stmt->close();
    }
}
