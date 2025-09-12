<?php
    require_once __DIR__ . "Config/conexion.php";
    class SolicitudT {
        private $db;

        public function __construct() {
            $this->db = conectar();
        }

        public function crear($titulo, $descripcion, $cliente_id, $imagen, $prioridad, $categoria_id, $estado_id) {
            $sql = "INSERT INTO solicitud 
                    (titulo, descripcion, cliente_id, imagen, prioridad, categoria_id, estado_id) 
                    VALUES (:titulo, :descripcion, :cliente_id, :imagen, :prioridad, :categoria_id, :estado_id)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':titulo' => $titulo,
                ':descripcion' => $descripcion,
                ':cliente_id' => $cliente_id,
                ':imagen' => $imagen,
                ':prioridad' => $prioridad,
                ':categoria_id' => $categoria_id,
                ':estado_id' => $estado_id
            ]);
    }

    public function obtenerTodas() {
        $sql = "SELECT s.*, u.nombre AS cliente_nombre, t.nombre AS tecnico_nombre, 
                       c.nombre AS categoria_nombre, e.nombre AS estado_nombre
                FROM solicitud s
                JOIN usuario u ON s.cliente_id = u.id
                LEFT JOIN usuario t ON s.tecnico_id = t.id
                JOIN categoria c ON s.categoria_id = c.id
                LEFT JOIN estado e ON s.estado_id = e.id
                ORDER BY s.fecha_creacion DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetch_all(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM solicitud WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function aceptar($id, $tecnico_id, $estado_id) {
        $sql = "UPDATE solicitud 
                SET tecnico_id = :tecnico_id, estado_id = :estado_id, fecha_actualizacion = CURRENT_TIMESTAMP 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':tecnico_id' => $tecnico_id,
            ':estado_id' => $estado_id,
            ':id' => $id
        ]);
    }

    public function editar($id, $titulo, $descripcion, $imagen, $prioridad, $categoria_id, $estado_id) {
        $sql = "UPDATE solicitud 
                SET titulo = :titulo,
                    descripcion = :descripcion,
                    imagen = :imagen,
                    prioridad = :prioridad,
                    categoria_id = :categoria_id,
                    estado_id = :estado_id,
                    fecha_actualizacion = CURRENT_TIMESTAMP
                WHERE id = :id AND tecnico_id IS NULL";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':titulo' => $titulo,
            ':descripcion' => $descripcion,
            ':imagen' => $imagen,
            ':prioridad' => $prioridad,
            ':categoria_id' => $categoria_id,
            ':estado_id' => $estado_id,
            ':id' => $id
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM solicitud WHERE id = :id AND tecnico_id IS NULL";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
            
    }