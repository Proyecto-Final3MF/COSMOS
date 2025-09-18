<?php
require_once(__DIR__ . '/../Config/conexion.php');

class Solicitud {

    private $conn;

    public function __construct() {  
        $this->conn = conectar();
    }

    public function obtenerProductos(){
        $sql = "SELECT * FROM producto";
        $resultado = $this->conn->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerProductoporId($producto_id) {
        $producto_id = (int)$producto_id;
        $sql = "SELECT nombre FROM producto WHERE id = $producto_id LIMIT 1";
        $result = $this->conn->query($sql);     
        if ($row = $result->fetch_assoc()) {
            return $row['nombre'];
        }
        return null;
    }

    public function borrarS($id) {
        $sql = "DELETE FROM solicitud WHERE id=$id AND tecnico_id=NULL";
        return $this->conn->query($sql);
    }

    public function ListarSLU($id_usuario){
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

    public function ListarTL() {
        $sql = "SELECT s.*, p.nombre AS nombre_producto, p.imagen, u.nombre AS nombre_cliente 
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

    public function asignarS($id_usuario, $id_soli){
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

    public function updateSolicitudEstado($solicitudId, $newEstadoId) {
        $sql = "UPDATE solicitud SET estado_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $newEstadoId, $solicitudId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function crearS($titulo, $descripcion, $producto, $usuario_id, $prioridad) {
        $titulo = $this->conn->real_escape_string($titulo);
        $descripcion = $this->conn->real_escape_string($descripcion);
        $sql = "INSERT INTO solicitud (titulo, cliente_id, fecha_creacion, prioridad, producto_id, estado_id, descripcion) VALUES ('$titulo', $usuario_id, NOW(), '$prioridad', $producto, 1, '$descripcion')";
        return $this->conn->query($sql);
    }

    public function cancelar($id) {
        $sql = "SELECT estado_id FROM solicitud WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
        error_log("Error al preparar la declaración select al cancelar: " . $this->conn->error);
        return false;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $estado_id_actual = $row['estado_id'];
            $stmt->close();
            if ($estado_id_actual !== 1) {
                $sql = "UPDATE solicitud SET estado_id = 1 WHERE id = ?";
                $stmt_update = $this->conn->prepare($sql);    
                if (!$stmt_update) {
                error_log("Error al preparar la declaración de actualización al cancelar: " . $this->conn->error);
                return false;
                }
                $stmt_update->bind_param("i", $id);
                $success = $stmt_update->execute();
                $stmt_update->close();
                return $success ? 'updated' : false;
            } else {
                $sql = "DELETE FROM solicitud WHERE id = ?";
                $stmt_delete = $this->conn->prepare($sql);
                if (!$stmt_delete) {
                error_log("Error al preparar la declaración de eliminación en cancelar: " . $this->conn->error);
                return false;
                }
                $stmt_delete->bind_param("i", $id);
                $success = $stmt_delete->execute();
                $stmt_delete->close();
                return $success ? 'deleted' : false;
            }
        } else {
            error_log("No se encontró solicitud con ID $id o error al obtener el estado al cancelar.");
            return false;
        }
    }

    public function __destruct() {
    }

}

?>