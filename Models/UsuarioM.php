<?php
class Usuario {
    private $conn;
    private $rolId;

    public function __construct() {
        $this->conn = conectar();
    }

    // En la clase Usuario (UsuarioM.php)
    public function crearT($usuario, $mail, $rol_id, $contrasena_hash, $otra_especialidad) {
        $estado_verificacion = 'pendiente'; // Específico para Técnicos
        $foto_perfil_default = "Assets/imagenes/perfil/fotodefault.webp"; 
        
        $sql = "INSERT INTO usuario (nombre, contrasena, email, rol_id, evidencia_tecnica_ruta, otra_especialidad, foto_perfil, estado_verificacion) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)"; 
        
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            error_log("MySQLi Prepare Error (crearT): " . $this->conn->error);
            return false;
        }

        // Tipos de parámetros: s s s i s s s s
        $stmt->bind_param("sssissss", 
            $usuario, 
            $contrasena_hash, // Usar el hash
            $mail, 
            $rol_id,
            $ruta_evidencia, 
            $otra_especialidad, 
            $foto_perfil_default, 
            $estado_verificacion
        );
        
        $success = $stmt->execute();
        
        if (!$success) {
            error_log("MySQLi Execute Error (crearT): " . $stmt->error);
        }
        
        $stmt->close();
        return $success;
    }

    public function crearC($usuario, $mail, $rol_id, $contrasena_hash) {
        $estado_verificacion = 'aprobado'; 
        $ruta_evidencia = null; 
        $otra_especialidad = null; 
        $foto_perfil_default = "Assets/imagenes/perfil/fotodefault.webp"; 
        
        $sql = "INSERT INTO usuario (nombre, contrasena, email, rol_id, evidencia_tecnica_ruta, otra_especialidad, foto_perfil, estado_verificacion) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)"; 
        
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            // 🛑 PUNTO DE FALLO 1: Error al preparar la consulta
            // Esto indica un problema con la sintaxis SQL, nombre de tabla/columna, o la conexión.
            die("❌ ERROR AL PREPARAR LA CONSULTA (PREPARE): " . $this->conn->error . " | SQL: " . $sql);
            // Quita la línea 'die' una vez resuelto el problema.
            return false;
        }

        // Tipos de parámetros: s s s i s s s s
        $stmt->bind_param("sssissss", 
            $usuario, 
            $contrasena_hash, 
            $mail, 
            $rol_id, 
            $ruta_evidencia, 
            $otra_especialidad, 
            $foto_perfil_default, 
            $estado_verificacion
        );
        
        $success = $stmt->execute();
        
        if (!$success) {
            // 🛑 PUNTO DE FALLO 2: Error al ejecutar la consulta
            // Esto indica una violación de restricción (ej. 'email' duplicado, 'rol_id' inválido, longitud de datos).
            die("❌ ERROR AL EJECUTAR LA CONSULTA (EXECUTE): " . $stmt->error);
            // Quita la línea 'die' una vez resuelto el problema.
        }
        
        $stmt->close();
        return $success;
    }

    // Especializaciones

    public function obtenerEspecializaciones() {
        $sql = "SELECT id, nombre FROM especializacion ORDER BY nombre ASC";
        $resultado = $this->conn->query($sql);
        if ($resultado) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function guardarEspecializaciones($usuario_id, $ids_array) {
        if (empty($ids_array)) return true;
        
        $sql = "INSERT INTO usuario_especializacion (usuario_id, especializacion_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            error_log("MySQLi Prepare Error (guardarEspecializaciones): " . $this->conn->error);
            return false;
        }

        $success = true;
        foreach ($ids_array as $especializacion_id) {
            $especializacion_id = (int)$especializacion_id;
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

    // Obtener usuario
    
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

    // Verificar login
    
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

    // Roles

    public function setRolId($rolId) {
        $this->rolId = $rolId;
    }

    public function getRolId() {
        return $this->rolId;
    }
    
    public function obtenerRol() {
        $sql = "SELECT * FROM rol WHERE id < 3";
        $resultado = $this->conn->query($sql);
        return $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
    }

    // CRUD básico

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

    // Listado de usuarios con filtros
    
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
            case 'Clientes': $conditions[] = "u.rol_id = 2"; break;
            case 'Tecnicos': $conditions[] = "u.rol_id = 1"; break;
            case 'Administradores': $conditions[] = "u.rol_id = 3"; break;
            case 'Todos':
            default: break;
        }

        if (!empty($conditions)) $sql .= " WHERE " . implode(" AND ", $conditions);

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

        if (!empty($param_types)) $stmt->bind_param($param_types, ...$params);
        if (!$stmt->execute()) {
            error_log("MySQLi Execute Error: " . $stmt->error);
            $stmt->close();
            return [];
        }

        $resultado = $stmt->get_result();
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }

    // Vista previa (últimos usuarios)
    
    public function PreviewU() {
        $sql = "SELECT u.*, r.nombre as rol FROM usuario u INNER JOIN rol r ON u.rol_id = r.id ORDER BY id DESC LIMIT 10";
        $resultado = $this->conn->query($sql);
        return $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Eliminar usuario

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

    public function buscarUserId($id) {
        $sql = "SELECT * FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            error_log("MySQLi Prepare Error: " . $this->conn->error);
            return [];
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log("MySQLi Execute Error: " . $stmt->error);
            $stmt->close();
            return [];
        }

        $resultado = $stmt->get_result();
        $data = $resultado->fetch_assoc();
        $stmt->close();
        return $data;
    }

    public function getEspecializacion($id_tecnico) {
        $sql = "SELECT e.nombre FROM especializacion e JOIN usuario_especializacion ue ON e.id = ue.especializacion_id WHERE ue.usuario_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_tecnico);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();

        if ($fila !== null) {
            return $fila['nombre'];
        } else {
            return null; 
        }
    }

    // Verificación de técnicos
    
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
        return $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
    }
}
?>