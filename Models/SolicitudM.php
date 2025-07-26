<?php
require_once(__DIR__ . '/../config/conexion.php');

class Solicitud {
    private $conn;

    public function __construct() {
        $this->conn = conectar();
    }

    public function getSolicitudesDisponibles() {
        $sql = "SELECT solicitud.id, solicitud.descripcion AS descripcion, estado.nombre AS estado
                FROM solicitud
                JOIN estado ON solicitud.estado_id = estado.id
                WHERE solicitud.estado_id = 1";
        $resultado = $this->conn->query($sql);

        if (!$resultado) {
            error_log("Error en la consulta getSolicitudesDisponibles: " . $this->conn->error);
            return [];
        }

        $solicitudes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $solicitudes[] = $fila;
        }
        return $solicitudes;
    }

    public function getSolicitudesOcupadas($estado_filter = 'all') {
        $sql = "SELECT solicitud.id, solicitud.descripcion AS descripcion, estado.nombre AS estado
        FROM solicitud
        JOIN estado ON solicitud.estado_id = estado.id";

$conditions = [];
$params = [];
$param_types = ''; // String to hold parameter types for bind_param

// Add the tecnico_id condition first
if (isset($Tid)) { // Make sure $Tid is actually set
    $conditions[] = "solicitud.tecnico_id = ?";
    $params[] = $Tid;
    $param_types .= 'i'; // Assuming tecnico_id is an integer ('i')
} else {
    // Handle the case where $Tid is not set, perhaps throw an error or set a default.
    // For now, let's assume it should always be set.
    error_log("Error: \$Tid is not set in SolicitudM.php for getSolicitudesOcupadas");
    // You might want to return false, throw an exception, or handle this gracefully.
    return false;
}


// Add the estado_filter condition
if ($estado_filter === 'all') {
    $conditions[] = "solicitud.estado_id != 1";
    // No parameter needed for this specific '!= 1' condition
} else {
    $filter_id = (int)$estado_filter; // Cast to int for safety
    $conditions[] = "solicitud.estado_id = ?";
    $params[] = $filter_id;
    $param_types .= 'i'; // Assuming estado_id is an integer ('i')
}


// Construct the WHERE clause if there are conditions
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Add ORDER BY or LIMIT if needed (e.g., for pagination)
// $sql .= " ORDER BY solicitud.fecha_creacion DESC";

// --- Debugging (Crucial Step) ---
error_log("Final SQL Query: " . $sql); // Log to PHP error log
// echo "<pre>Final SQL Query: " . htmlspecialchars($sql) . "</pre>"; // For browser output (remove in production)
// var_dump($params); // Check parameters
// var_dump($param_types); // Check parameter types


// Prepare the statement
$stmt = $this->db->prepare($sql); // Assuming $this->db is your mysqli connection object

if ($stmt === false) {
    // Handle the prepare error (e.g., log it, show a user-friendly message)
    error_log("MySQLi Prepare Error: " . $this->db->error . " | SQL: " . $sql);
    throw new mysqli_sql_exception("Failed to prepare statement: " . $this->db->error);
}

// Bind parameters if there are any
if (!empty($params)) {
    call_user_func_array([$stmt, 'bind_param'], array_merge([$param_types], refValues($params)));
}

// Execute the statement
$stmt->execute();

// Get results
$result = $stmt->get_result();

// ... fetch your data ...

$stmt->close();

        $stmt = $this->conn->prepare($sql);

        if ($estado_filter !== 'all') {
            $stmt->bind_param("i", $filter_id);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();

        if (!$resultado) {
            error_log("Error en la consulta getSolicitudesOcupadas: " . $this->conn->error);
            return [];
        }

        $solicitudes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $solicitudes[] = $fila;
        }
        $stmt->close();
        return $solicitudes;
    }

    public function updateSolicitudEstado($solicitudId, $newEstadoId) {
        $sql = "UPDATE solicitud SET estado_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $newEstadoId, $solicitudId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function crear($titulo, $descripcion, $categoria_id, $usuario_id, $prioridad = 'media') {
        $titulo = $this->conn->real_escape_string($titulo);
        $descripcion = $this->conn->real_escape_string($descripcion);
        
        $sql = "INSERT INTO solicitud (titulo, descripcion, categoria_id, usuario_id, prioridad) 
                VALUES ('$titulo', '$descripcion', $categoria_id, $usuario_id, '$prioridad')";
        
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