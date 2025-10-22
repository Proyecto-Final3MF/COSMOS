<?php
class Usuario {
    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

    public function crearU($usuario, $mail, $rol_id, $contrasena, $ruta_evidencia = null, $otra_especialidad = null) {
      
        $ROL_TECNICO_ID = '1';
        
        $estado_verificacion = ($rol_id == $ROL_TECNICO_ID) ? 'pendiente' : 'aprobado';
        
        $usuario = $this->conn->real_escape_string($usuario);
        $mail = $this->conn->real_escape_string($mail);
        $contrasena = $this->conn->real_escape_string($contrasena);
        
        $ruta_evidencia_escaped = $ruta_evidencia ? "'" . $this->conn->real_escape_string($ruta_evidencia) . "'" : 'NULL';
        $otra_especialidad_escaped = $otra_especialidad ? "'" . $this->conn->real_escape_string($otra_especialidad) . "'" : 'NULL';
        $estado_verificacion_escaped = "'" . $estado_verificacion . "'";

        $foto_perfil_default = "'Assets/imagenes/perfil/fotodefault.webp'"; 

        $sql = "INSERT INTO usuario (nombre, contrasena, email, rol_id, evidencia_tecnica_ruta, otra_especialidad, foto_perfil, estado_verificacion) 
                VALUES ('$usuario', '$contrasena', '$mail', '$rol_id', $ruta_evidencia_escaped, $otra_especialidad_escaped, $foto_perfil_default, $estado_verificacion_escaped)";
                
        return $this->conn->query($sql);
    }

    public function obtenerEspecializaciones() {
        $sql = "SELECT id, nombre FROM especializacion ORDER BY nombre ASC";
        $resultado = $this->conn->query($sql);
        if ($resultado) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function guardarEspecializaciones($usuario_id, $ids_array) {
        if (empty($ids_array)) {
            return true;
        }
        
        $sql = "INSERT INTO usuario_especializacion (usuario_id, especializacion_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            error_log("MySQLi Prepare Error (guardarEspecializaciones): " . $this->conn->error);
            return false;
        }

        $success = true;
        
        foreach ($ids_array as $especializacion_id) {
            $especializacion_id = (int) $especializacion_id;
            
            if ($usuario_id > 0 && $especializacion_id > 0) {
                $stmt->bind_param("ii", $usuario_id, $especializacion_id);
                if (!$stmt->execute()) {
                    error_log("MySQLi Execute Error (guardarEspecializaciones): " . $stmt->error);
                    $success = false;
                }
            }
        }
        
        $stmt->close();
        return $success;
    }
    return false;
    }


    public function obtenerPorNombre($usuario) {
    $usuario = $this->conn->real_escape_string($usuario);
    $sql = "SELECT * FROM usuario WHERE nombre = '$usuario' LIMIT 1";
    $res = $this->conn->query($sql);
    if ($res && $res->num_rows > 0) {
        return $res->fetch_assoc();
    }
    return false;
}

public function obtenerPorEmail($email) {
    $email = $this->conn->real_escape_string($email);
    $sql = "SELECT * FROM usuario WHERE email = '$email' LIMIT 1";
    $res = $this->conn->query($sql);
    if ($res && $res->num_rows > 0) {
        return $res->fetch_assoc();
    }
    return false;
}

    public function verificarU($usuario, $contrasena) {
        $usuario = $this->conn->real_escape_string($usuario);
        $sql = "SELECT * FROM usuario WHERE nombre='$usuario' LIMIT 1";
        $res = $this->conn->query($sql);

        if ($row = $res->fetch_assoc()) {
            if (password_verify($contrasena, $row['contrasena'])) {
                return $row;
            }
        }
        return false;
    }


    public function obtenerPorNombre($usuario) {
        $usuario = $this->conn->real_escape_string($usuario);
        $sql = "SELECT * FROM usuario WHERE nombre = '$usuario' LIMIT 1";
        $res = $this->conn->query($sql);
        if ($res && $res->num_rows > 0) {
            return $res->fetch_assoc();
        }
        return false;
    }

    public function obtenerPorEmail($email) {
        $email = $this->conn->real_escape_string($email);
        $sql = "SELECT * FROM usuario WHERE email = '$email' LIMIT 1";
        $res = $this->conn->query($sql);
        if ($res && $res->num_rows > 0) {
            return $res->fetch_assoc();
        }
        return false;
    }

    public function obtenerRol() {
        $sql = "SELECT * FROM rol where id < 3";
        $resultado = $this->conn->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarUserId($id) {
        $sql = "SELECT * FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function editarU($id, $nombre, $email, $foto_perfil = null) {
        if ($foto_perfil) {
            $sql = "UPDATE usuario SET nombre = ?, email = ?, foto_perfil = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssi", $nombre, $email, $foto_perfil, $id);
        } else {
            $sql = "UPDATE usuario SET nombre = ?, email = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $nombre, $email, $id);
        }
        return $stmt->execute();
    }

    public function actualizarContrasena($id, $nuevoHash) {
        $sql = "UPDATE usuario SET contrasena = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $nuevoHash, $id);
        return $stmt->execute();
    }

    public function listarU($orden, $rol_filter, $search) {
        $sql = "SELECT u.*, r.nombre as rol FROM usuario u INNER JOIN rol r ON u.rol_id = r.id ";

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
            case 'Clientes': $conditions[] = "u.rol_id = 2 "; break;
            case 'Tecnicos': $conditions[] = "u.rol_id = 1 "; break;
            case 'Administradores': $conditions[] = "u.rol_id = 3 "; break;
            case 'Todos':
            default: break;
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
            
        if (!$stmt) {
            error_log("MySQLi Prepare Error: " . $this->conn->error);
            return [];
        }

        if (!empty($param_types)) {
            $stmt->bind_param($param_types, ...$params);
        }
            
        $success = $stmt->execute();
            
        if ($success) {
            $resultado = $stmt->get_result();
            $data = $resultado->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
                    
            return $data;
        } else {
            error_log("MySQLi Execute Error: " . $stmt->error);
            $stmt->close();
            return [];
        }

    }

    public function PreviewU() {
        $sql = "SELECT u.*, r.nombre as rol FROM usuario u INNER JOIN rol r ON u.rol_id = r.id ORDER BY id DESC LIMIT 10";
        $resultado = $this->conn->query($sql);
        if ($resultado) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function borrar($id){
        $usuario = $this->buscarUserId($id);
        if ($usuario && $usuario['foto_perfil'] !== "Assets/imagenes/perfil/fotodefault.webp" && file_exists($usuario['foto_perfil'])) {
            unlink($usuario['foto_perfil']);
        }
        $sql = "DELETE FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getDatosTecnico($id_tecnico) {
        $sql = "SELECT* FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            error_log("MySQLi Prepare Error: " . $this->conn->error);
            return [];
        }

        $stmt->bind_param("i", $id_tecnico);
        $success = $stmt->execute();

        if ($success) {
            $resultado = $stmt->get_result();
            $data = $resultado->fetch_assoc();
            $stmt->close();
                    
            return $data;
        } else {
            error_log("MySQLi Execute Error: " . $stmt->error);
            $stmt->close();
            return [];
        }
    }
    
    // --- NUEVOS MÉTODOS DE VERIFICACIÓN ---

    public function actualizarEstadoVerificacion($id, $estado) {
        $sql = "UPDATE usuario SET estado_verificacion = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $estado, $id);
        return $stmt->execute();
    }

    public function obtenerTecnicosPendientes() {
        $sql = "SELECT id, nombre, email, evidencia_tecnica_ruta, foto_perfil FROM usuario 
                WHERE rol_id = 1 AND estado_verificacion = 'pendiente'"; 
        $resultado = $this->conn->query($sql);
        
        if ($resultado) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
?>