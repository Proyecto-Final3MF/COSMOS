<?php
//echo "DEBUG: HistorialmODEL.php está sendo carregado.<br>";

require_once __DIR__ . '/../Config/conexion.php';

class HistorialModel {
    private $conexion;

    public function __construct() {
        $this->conexion = conectar();
        // It's good practice to set charset for consistency
        if ($this->conexion) {
            $this->conexion->set_charset("utf8mb4");
        }
    }

    public function registrarModificacao($usuario_id, $item, $solicitud_id, $obs) {
        //echo "DEBUG: registrarModificacao - Usuario ID: " . ($usuario_id ?? 'NULL') . ", Item: " . $item . ", Solicitud ID: " . $solicitud_id . ", Obs: " . $obs . "<br>";

        $usuario_id_para_db = ($usuario_id === 0 || $usuario_id === null) ? NULL : $usuario_id;

        //echo "DEBUG: Before bind_param - item type: " . gettype($item) . ", item value: '" . $item . "'<br>";

        // --- TEMPORARY DEBUGGING CHANGE START ---
        // Escape the item string to prevent SQL injection for this test
        $escaped_item = $this->conexion->real_escape_string($item);

        // Build the query with item directly embedded
        $query = "INSERT INTO historial (usuario_id, item, solicitud_id, fecha_hora, obs)
                  VALUES (?, '" . $escaped_item . "', ?, NOW(), ?)";

        $stmt = $this->conexion->prepare($query);

        if ($stmt === false) {
            //echo "DEBUG: Erro ao preparar statement no HistorialModel: " . $this->conexion->error . "<br>";
            return false;
        }

        // Bind parameters for usuario_id, solicitud_id, and obs (item is now direct)
        // Notice 'i' for usuario_id, 'i' for solicitud_id, 's' for obs
        $stmt->bind_param("iis", $usuario_id_para_db, $solicitud_id, $obs);
        // --- TEMPORARY DEBUGGING CHANGE END ---

        $success = $stmt->execute();

        if ($success) {
            //echo "DEBUG: Inserção no histórico BEM-SUCEDIDA.<br>";
        } else {
           // echo "DEBUG: Inserção no histórico FALHOU. Erro: " . $stmt->error . "<br>";
            // Also print the stmt error here for more detail
            //echo "DEBUG: Statement Error: " . $stmt->error . "<br>";
        }

        $stmt->close();
        return $success;
    }

    public function getHistorial() {
        $historial = [];
        //echo "DEBUG: getHistorial - Buscando histórico...<br>";
        $query = "SELECT h.id, h.usuario_id, u.nombre AS nombre_usuario, h.item, h.solicitud_id, h.fecha_hora, h.obs
                  FROM historial h
                  LEFT JOIN usuario u ON h.usuario_id = u.id
                  ORDER BY h.fecha_hora DESC";
        $resultado = $this->conexion->query($query);

        if ($resultado === false) {
            //echo "DEBUG: Erro na query getHistorial: " . $this->conexion->error . "<br>";
        } else {
           // echo "DEBUG: Query getHistorial executada com sucesso. Linhas encontradas: " . $resultado->num_rows . "<br>";
            while ($fila = $resultado->fetch_object()) {
                $historial[] = $fila;
            }
            $resultado->free();
        }
        return $historial;
    }

    public function __destruct() {
        if ($this->conexion && $this->conexion->ping()) {
             $this->conexion->close();
        }
    }
}
?>