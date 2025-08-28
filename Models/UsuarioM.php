<?php
class Usuario {
    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

    public function crearU($usuario, $mail, $rol_id, $contrasena) {
        $usuario = $this->conn->real_escape_string($usuario);
        $mail = $this->conn->real_escape_string($mail);
        $contrasena = $this->conn->real_escape_string($contrasena);
        
        $sql = "INSERT INTO usuario (nombre, contrasena, email, rol_id) VALUES ('$usuario', '$contrasena', '$mail', '$rol_id')";
        return $this->conn->query($sql);
    }

    public function verificar($usuario, $contrasena) {
        $usuario = $this->conn->real_escape_string($usuario);
        $sql = "SELECT * FROM usuario WHERE nombre='$usuario' LIMIT 5";
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

    public function getRoleNameById($role_id) {
        $role_id = (int)$role_id;
        $sql = "SELECT nombre FROM rol WHERE id = $role_id LIMIT 1";
        $result = $this->conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            return $row['nombre'];
        }
        return null;
    }
    public function actualizarU($id, $nombre, $email) {
    $id = (int)$id;
    $nombre = $this->conn->real_escape_string($nombre);
    $email = $this->conn->real_escape_string($email);
    $sql = "UPDATE usuario SET nombre='$nombre', email='$email' WHERE id=$id";
    return $this->conn->query($sql);
    }
    public function borrar($id){
            $sql = "DELETE FROM usuario WHERE id=$id";
            return $this->conn->query($sql);
        }
}
?>