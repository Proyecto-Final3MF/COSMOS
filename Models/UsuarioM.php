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

    public function obtenerRol() {
        $sql = "SELECT * FROM rol";
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

    public function listarU($orden, $rol_filter) {
        $sql = "SELECT * FROM usuario ";

        switch ($rol_filter) {
            case 'Todos': break;
            case 'Clientes': $sql .= "WHERE rol_id = 2 "; break;
            case 'Tecnicos': $sql .= "WHERE rol_id = 1 "; break;
            case 'Administradores': $sql .= "WHERE rol_id = 3 "; break;
            default: break;
        }

        switch ($orden) {
            case "A-Z": $sql .= "ORDER BY nombre ASC"; break;
            case "Z-A": $sql .= "ORDER BY nombre DESC"; break;
            case "Más Recientes": $sql .= "ORDER BY id DESC"; break;
            case "Más Antiguos": $sql .= "ORDER BY id ASC"; break;
            default: $sql .= "ORDER BY id ASC"; break;
        }

        $resultado = $this->conn->query($sql);
        $usuarios = [];
        if ($resultado) {
            while ($row = $resultado->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }
        return $usuarios;
    }

    public function borrar($id){
        // Antes de borrar, eliminar foto si no es default
        $usuario = $this->buscarUserId($id);
        if ($usuario && $usuario['foto_perfil'] !== "Assets/imagenes/perfil/fotodefault.webp" && file_exists($usuario['foto_perfil'])) {
            unlink($usuario['foto_perfil']);
        }
        $sql = "DELETE FROM usuario WHERE id = $id";
        return $this->conn->query($sql);
    }
}
?>