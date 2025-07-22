<?php
echo "DEBUG: HistorialController.php está sendo carregado.<br>";

require_once __DIR__ . '/../models/HistorialModel.php';

class HistorialController {
    private $historialModel;

    public function __construct() {
        $this->historialModel = new HistorialModel();
    }

    /**
     * Exibe a página do histórico.
     */
    public function mostrarHistorial() {
        $historial = $this->historialModel->getHistorial();
        // Inclui a view para exibir o histórico
        include __DIR__ . '/../views/historial_view.php';
    }

    /**
     * Exemplo de como você chamaria esta função para registrar uma modificação.
     * Isso seria chamado no seu código de lógica de negócios (onde as solicitações são salvas/atualizadas).
     * @param int $usuario_id ID do usuário.
     * @param string $item Tipo do item (e.g., 'solicitacao').
     * @param int $solicitud_id ID da solicitação.
     * @param string $obs Observação da modificação.
     */
    public function registrarModificacao($usuario_id, $item, $solicitud_id, $obs) {
        // O terceiro parâmetro agora é $solicitud_id
        $this->historialModel->registrarModificacao($usuario_id, $item, $solicitud_id, $obs);
    }
}