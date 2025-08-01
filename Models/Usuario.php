<?php
class Usuario {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }

    
    public function crear($usuario, $mail, $rol_id, $contrasena) {
        $usuario = $this->db->real_escape_string($usuario);
        $mail = $this->db->real_escape_string($mail);
        $contrasena = $this->db->real_escape_string($contrasena);
        
        $sql = "INSERT INTO usuario (nombre, contrasena, email, rol_id) VALUES ('$usuario', '$contrasena', '$mail', '$rol_id')";
        return $this->db->query($sql);
    }

    public function verificar($usuario, $contrasena) {
        $usuario = $this->db->real_escape_string($usuario);
        $sql = "SELECT * FROM usuario WHERE nombre='$usuario' LIMIT 5";
        $res = $this->db->query($sql);
        if ($row = $res->fetch_assoc()) {
            if ($row['contrasena'] === $contrasena) {
                return $row;
            }
        }
        return false;
    }

    public function obtenerRol() {
        $sql = "SELECT * FROM rol";
        $resultado = $this->db->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function getRoleNameById($role_id) {
        $role_id = (int)$role_id;
        $sql = "SELECT nombre FROM rol WHERE id = $role_id LIMIT 1";
        $result = $this->db->query($sql);
        if ($row = $result->fetch_assoc()) {
            return $row['nombre'];
        }
        return null;
    }

}
?>