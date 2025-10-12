<?php
class Usuario {
    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

    public function crearU($usuario, $mail, $rol_id, $contrasena, $foto_perfil) {
        $usuario = $this->conn->real_escape_string($usuario);
        $mail = $this->conn->real_escape_string($mail);
        $contrasena = $this->conn->real_escape_string($contrasena);
        $foto_perfil = $this->conn->real_escape_string($foto_perfil);

        $sql = "INSERT INTO usuario (nombre, contrasena, email, rol_id, foto_perfil) 
                VALUES ('$usuario', '$contrasena', '$mail', '$rol_id', '$foto_perfil')";
        return $this->conn->query($sql);
    }

    public function verificarU($usuario, $contrasena) {
        $usuario = $this->conn->real_escape_string($usuario);
        $sql = "SELECT * FROM usuario WHERE nombre='$usuario' LIMIT 1";
        $res = $this->conn->query($sql);
        if ($row = $res->fetch_assoc()) {
            if ($row['contrasena'] === $contrasena) {
                return $row;
            }
        }
        return false;
    }

    public function obtenerRolPorId($id) {
        $sql = "SELECT rol_id FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['rol_id'] ?? null;
    }

    public function actualizarUsuario($id, $nombre, $email, $foto_perfil, $rol_id) {
        $sql = "UPDATE usuario 
                SET nombre = ?, email = ?, foto_perfil = ?, rol_id = ? 
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssii", $nombre, $email, $foto_perfil, $rol_id, $id);
        return $stmt->execute();
    }

    public function buscarUserId($id) {
        $sql = "SELECT u.*, r.nombre AS rol 
                FROM usuario u 
                INNER JOIN rol r ON u.rol_id = r.id 
                WHERE u.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function listarU($orden, $rol_filter, $search) {
        $sql = "SELECT u.*, r.nombre as rol FROM usuario u 
                INNER JOIN rol r ON u.rol_id = r.id ";

        $conditions = [];
        $params = [];
        $param_types = '';

        if (!empty($search)) {
            $search_terms = explode(" ", $search);
            foreach ($search_terms as $palabra) {
                $conditions[] = "(u.nombre LIKE ? OR u.email LIKE ?)";
                $search_term = "%" . $palabra . "%";
                $params[] = $search_term;
                $params[] = $search_term;
                $param_types .= 'ss';
            }
        }

        switch ($rol_filter) {
            case 'Clientes': $conditions[] = "u.rol_id = 2"; break;
            case 'Tecnicos': $conditions[] = "u.rol_id = 1"; break;
            case 'Administradores': $conditions[] = "u.rol_id = 3"; break;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        switch ($orden) {
            case "A-Z": $sql .= " ORDER BY u.nombre ASC"; break;
            case "Z-A": $sql .= " ORDER BY u.nombre DESC"; break;
            case "Más Recientes": $sql .= " ORDER BY u.id DESC"; break;
            case "Más Antiguos": $sql .= " ORDER BY u.id ASC"; break;
            default: $sql .= " ORDER BY u.id ASC"; break;
        }

        $stmt = $this->conn->prepare($sql);
        if (!empty($param_types)) {
            $stmt->bind_param($param_types, ...$params);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }

    public function borrar($id) {
        $usuario = $this->buscarUserId($id);
        if ($usuario && $usuario['foto_perfil'] !== "Assets/imagenes/perfil/fotodefault.webp" && file_exists($usuario['foto_perfil'])) {
            unlink($usuario['foto_perfil']);
        }
        $sql = "DELETE FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>