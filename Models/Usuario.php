<?php
class Usuario {
    private $db;

    public function __construct() {
        $this->db = conectar();
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
}
?>