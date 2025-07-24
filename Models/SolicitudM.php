<?php
require_once(__DIR__ . '/../config/conexion.php');

class Solicitud {
    private $db;
    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

    public function getSolicitudesDisponibles() {
        $sql = "SELECT solicitud.id, solicitud.obs AS obs, estado.nombre AS estado
                FROM solicitud
                JOIN estado ON solicitud.estado_id = estado.id
                WHERE solicitud.estado_id = 1";
        $resultado = $this->conn->query($sql);

        if (!$resultado) {
            error_log("Error en la consulta getSolicitudesDisponibles: " . $this->conn->error);
            return [];
        }

        $solicitudes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $solicitudes[] = $fila;
        }
        return $solicitudes;
    }

    public function getSolicitudesOcupadas($estado_filter = 'all') {
        $sql = "SELECT solicitud.id, solicitud.obs AS obs, estado.nombre AS estado
                FROM solicitud
                JOIN estado ON solicitud.estado_id = estado.id";

        if ($estado_filter === 'all') {
            $sql .= " WHERE solicitud.estado_id != 1";
        } else {
            $filter_id = (int)$estado_filter;
            $sql .= " WHERE solicitud.estado_id = ?";
        }

        $stmt = $this->conn->prepare($sql);

        if ($estado_filter !== 'all') {
            $stmt->bind_param("i", $filter_id);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();

        if (!$resultado) {
            error_log("Error en la consulta getSolicitudesOcupadas: " . $this->conn->error);
            return [];
        }

        $solicitudes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $solicitudes[] = $fila;
        }
        $stmt->close();
        return $solicitudes;
    }

    public function updateSolicitudEstado($solicitudId, $newEstadoId) {
        $sql = "UPDATE solicitud SET estado_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $newEstadoId, $solicitudId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function __destruct() {
       
    }
}

    class Ticket {
        private $db;

        public function __construct() {

            $this->db = new mysqli("localhost", "root", "", "tu_base_datos");
            if ($this->db->connect_error) {
                die("Error de conexión: " . $this->db->connect_error);
            }
        }
        public function listar($usuario_id = null, $rol = null) {
            $sql = "SELECT t.*, c.nombre as categoria_nombre, u1.usuario as creador, u2.usuario as asignado FROM tickets t LEFT JOIN categorias_ticket c ON t.categoria_id = c.id LEFT JOIN usuarios u1 ON t.usuario_id = u1.id LEFT JOIN usuarios u2 ON t.asignado_a = u2.id";
            if ($rol !== 'admin') {
                $sql .= " WHERE t.usuario_id = $usuario_id";
            }
            $sql .= " ORDER BY t.fecha_creacion DESC";
            $resultado = $this->db->query($sql);
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
        public function crear($titulo, $descripcion, $categoria_id, $usuario_id, $prioridad ='media') {
            $titulo = $this->db->real_escape_string($titulo);
            $descripcion = $this->db->real_escape_string($descripcion);
            $sql = "INSERT INTO tickets (titulo, descripcion, categoria_id, usuario_id, prioridad) VALUES ('$titulo', '$descripcion', $categoria_id, $usuario_id, '$prioridad')";
            return $this->db->query($sql);
        }
        public function buscarPorId($id) {
            $sql = "SELECT t.*, c.nombre as categoria_nombre, u1.usuario as creador, u2.usuario as asignado FROM tickets t LEFT JOIN categorias_ticket c ON t.categoria_id = c.id LEFT JOIN usuarios u1 ON t.usuario_id = u1. id LEFT JOIN usuarios u2 ON t.asignado_a = u2.id WHERE t.id = $id";
            $resultado = $this->db->query($sql);
            return $resultado->fetch_assoc();
        }
        public function actualizar($id, $titulo, $descripcion, $categoria_id, $estado = null, $asignado_a = null,$prioridad = null) {
            $titulo = $this->db->real_escape_string($titulo);
            $descripcion = $this->db->real_escape_string($descripcion);
            $sql = "UPDATE tickets SET titulo='$titulo', descripcion='$descripcion', categoria_id=$categoria_id";
            if ($estado !== null) {
                $sql .= ", estado='$estado'";
            }
            if ($asignado_a !== null) {
                $sql .= ", asignado_a=$asignado_a";
            }
            if ($prioridad !== null) {
                $sql .= ", prioridad='$prioridad'";
            }
            $sql .= " WHERE id=$id";
            return $this->db->query($sql);
        }
        public function obtenerCategorias() {
            $sql = "SELECT * FROM categorias_ticket WHERE activo = TRUE ORDER BY nombre";
            $resultado = $this->db->query($sql);
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
        public function obtenerUsuarios() {
            $sql = "SELECT id, usuario FROM usuarios ORDER BY usuario";
            $resultado = $this->db->query($sql);
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
    }
?>