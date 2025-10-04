<?php
require_once(__DIR__ . '/../Config/conexion.php');

class Solicitud
{

    private $conn;

    public function __construct()
    {
        $this->conn = conectar();
    }

    public function obtenerProductos()
    {
        $sql = "SELECT * FROM producto";
        $resultado = $this->conn->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerProductoporId($producto_id)
    {
        $producto_id = (int)$producto_id;
        $sql = "SELECT nombre FROM producto WHERE id = $producto_id LIMIT 1";
        $result = $this->conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            return $row['nombre'];
        }
        return null;
    }

    public function borrarS($id)
    {
        $sql = "DELETE FROM solicitud WHERE id=$id AND tecnico_id=NULL";
        return $this->conn->query($sql);
    }

    public function ListarSLU($id_usuario)
    {
        $id_usuario = (int)$id_usuario;
        $sql = "SELECT s.*, p.nombre, p.imagen FROM solicitud s 
                inner join producto p on s.producto_id = p.id 
                WHERE s.cliente_id = $id_usuario AND s.estado_id = 1;";
        $resultado = $this->conn->query($sql);
        if ($resultado) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function ListarTL()
    {
        $sql = "SELECT s.*, p.nombre as producto, p.imagen, u.nombre
                FROM solicitud s
                INNER JOIN producto p ON s.producto_id = p.id
                INNER JOIN usuario u ON s.cliente_id = u.id
                WHERE s.estado_id = 1
                ORDER BY FIELD(s.prioridad, 'urgente', 'alta', 'media', 'baja'), s.fecha_creacion DESC";
        $resultado = $this->conn->query($sql);

        if ($resultado) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function asignarS($id_usuario, $id_soli)
    {
        // Utiliza una consulta preparada para mayor seguridad
        $sql = "UPDATE solicitud SET tecnico_id = ?, estado_id = 2 WHERE id = ?";

        // Prepara la declaración
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            error_log("Error al preparar la declaración: " . $this->conn->error);
            return false;
        }

        // Vincula los parámetros
        $stmt->bind_param("ii", $id_usuario, $id_soli);

        // Ejecuta la consulta
        $success = $stmt->execute();

        // Cierra la declaración
        $stmt->close();

        return $success;
    }

    public function ListarSA($id_usuario)
    {
        $id_usuario = (int)$id_usuario;
        $sql = "SELECT s.*, p.nombre, p.imagen FROM solicitud s 
                inner join producto p on s.producto_id = p.id 
                WHERE (s.tecnico_id = $id_usuario OR s.cliente_id = $id_usuario) AND s.estado_id > 1 AND s.estado_id < 5
                ORDER BY FIELD(s.prioridad, 'urgente', 'alta', 'media', 'baja'), s.fecha_actualizacion DESC;";
        $resultado = $this->conn->query($sql);
        if ($resultado) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function crearS($titulo, $descripcion, $producto, $usuario_id, $prioridad)
    {
        $titulo = $this->conn->real_escape_string($titulo);
        $descripcion = $this->conn->real_escape_string($descripcion);
        $sql = "INSERT INTO solicitud (titulo, cliente_id, fecha_creacion, prioridad, producto_id, estado_id, descripcion) VALUES ('$titulo', $usuario_id, NOW(), '$prioridad', $producto, 1, '$descripcion')";
        return $this->conn->query($sql);
    }

    public function obtenerSolicitudPorId($id)
    {
        $id = (int)$id;
        $sql = "SELECT * FROM solicitud WHERE id = $id LIMIT 1";
        $resultado = $this->conn->query($sql);
        return $resultado->fetch_assoc();
    }

    public function obtenerEstados()
    {
        $sql = "SELECT * FROM estado";
        $resultado = $this->conn->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function actualizarS($id, $descripcion, $estado_id)
    {
        $id = (int)$id;
        $descripcion = $this->conn->real_escape_string($descripcion);
        $estado_id = (int)$estado_id;

        $sql = "UPDATE solicitud SET descripcion = '$descripcion', estado_id = $estado_id, fecha_actualizacion = NOW() WHERE id = $id";
        return $this->conn->query($sql);
    }

    public function cancelarS($id_soli)
    {
        $id_soli = (int)$id_soli;
        $sql = "UPDATE solicitud SET tecnico_id = NULL, estado_id = 1 WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Error al preparar la cancelación de la solicitud: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("i", $id_soli);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function __destruct() {}
}
?>