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

    public function verificarU($usuario, $contrasena) {
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
   
  public function buscarUserId($id) {
        // Usa consultas preparadas para mayor seguridad
        $sql = "SELECT * FROM usuario WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function editarU($id, $nombre, $email) {
        // Usa consultas preparadas para actualizar los datos de manera segura
        $sql = "UPDATE usuario SET nombre = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $nombre, $email, $id);
        return $stmt->execute();
    }

   public function eliminar($id) {
    // Preparar la consulta para eliminar el usuario por id
    $sql = "DELETE FROM usuario WHERE id = ?";
    $stmt = $this->conn->prepare($sql);

    if ($stmt === false) {
        // Error al preparar la consulta
        error_log("Error en prepare(): " . $this->conn->error);
        return false;
    }

    // Vincular el parámetro id (entero)
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta
    $result = $stmt->execute();

    if ($result === false) {
        // Error al ejecutar la consulta
        error_log("Error en execute(): " . $stmt->error);
    }

    // Cerrar la sentencia preparada
    $stmt->close();

    return $result;
}

}
?>