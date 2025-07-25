<?php
class Usuario {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }

    
    public function crear($usuario, $mail, $rol_id, $constrasena) {        
        $sql = "INSERT INTO usuario (nombre, contrasena, email, rol_id) 
                VALUES ('$usuario', '$constrasena', '$mail', '$rol_id')";
        
        return $this->db->query($sql);

        
    }

    public function verificar($usuario, $password) {
        $usuario = $this->db->real_escape_string($usuario);
        $sql = "SELECT * FROM usuario WHERE usuario='$usuario' LIMIT 1";
        $res = $this->db->query($sql);
        if ($row = $res->fetch_assoc()) {
            if ($row['password'] === $password) {
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

}
?>