<?php
// models/HistorialModel.php
echo "DEBUG: HistorialmODEL.php está sendo carregado.<br>";

require_once __DIR__ . '/../Config/conexion.php';

class HistorialModel {
    private $conexion;

    public function __construct() {
        $this->conexion = conectar();
    }

    /**
     * Registra uma modificação no histórico.
     * @param int|null $usuario_id ID do usuário que fez a modificação (pode ser NULL por enquanto).
     * @param string $item Tipo de item modificado (ex: 'solicitacao').
     * @param int $solicitud_id ID da solicitação modificada.
     * @param string $obs Observação detalhada da modificação.
     */
     public function registrarModificacao($usuario_id, $item, $solicitud_id, $obs) {
        echo "DEBUG: registrarModificacao - Usuario ID: " . ($usuario_id ?? 'NULL') . ", Item: " . $item . ", Solicitud ID: " . $solicitud_id . ", Obs: " . $obs . "<br>";

        $usuario_id_para_db = ($usuario_id === 0 || $usuario_id === null) ? NULL : $usuario_id;

        $stmt = $this->conexion->prepare("INSERT INTO historial (usuario_id, item, solicitud_id, fecha_hora, obs) VALUES (?, ?, ?, NOW(), ?)");

        if ($stmt === false) {
            echo "DEBUG: Erro ao preparar statement no HistorialModel: " . $this->conexion->error . "<br>";
            return false;
        }

        $stmt->bind_param("iiss", $usuario_id_para_db, $item, $solicitud_id, $obs);
        $success = $stmt->execute();

        if ($success) {
            echo "DEBUG: Inserção no histórico BEM-SUCEDIDA.<br>";
        } else {
            echo "DEBUG: Inserção no histórico FALHOU. Erro: " . $stmt->error . "<br>";
        }

        $stmt->close();
        return $success;
    }

    // ... (restante do código, como getHistorial(), permanece o mesmo)
    public function getHistorial() {
        $historial = [];
        echo "DEBUG: getHistorial - Buscando histórico...<br>";
        $query = "SELECT h.id, h.usuario_id, u.nombre AS nombre_usuario, h.item, h.solicitud_id, h.fecha_hora, h.obs
                  FROM historial h
                  LEFT JOIN usuario u ON h.usuario_id = u.id
                  ORDER BY h.fecha_hora DESC";
        $resultado = $this->conexion->query($query);

        if ($resultado === false) {
            echo "DEBUG: Erro na query getHistorial: " . $this->conexion->error . "<br>";
        } else {
            echo "DEBUG: Query getHistorial executada com sucesso. Linhas encontradas: " . $resultado->num_rows . "<br>";
            while ($fila = $resultado->fetch_object()) {
                $historial[] = $fila;
            }
            $resultado->free();
        }
        return $historial;
    }

    public function __destruct() {
        $this->conexion->close();
    }
}