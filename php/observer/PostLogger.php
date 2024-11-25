<?php
require_once('PostObserver.php'); // Incluindo a interface PostObserver

class PostLogger implements PostObserver {
    private $logs = []; // Armazena as mensagens de log

    public function update(Post $post, $event) {
        $message = $this->generateLogMessage($post, $event);
        $this->logs[] = $message; // Adiciona a mensagem ao log
        
        // Debugging: Verificando o que está sendo adicionado ao log
        echo "Log registrado: $message<br>"; // Adiciona um log diretamente no navegador
    }

    private function generateLogMessage(Post $post, $event) {
        $timestamp = date('Y-m-d H:i:s');
        $postType = get_class($post);
        $conteudo = $post->getConteudo();

        switch ($event) {
            case 'created':
                return "[$timestamp] Novo post criado: $postType com conteúdo: $conteudo";
            case 'updated':
                return "[$timestamp] Post atualizado: $postType com novo conteúdo: $conteudo";
            case 'deleted':
                return "[$timestamp] Post excluído: $postType com conteúdo: $conteudo";
            default:
                return "[$timestamp] Evento desconhecido.";
        }
    }

    public function getLogs() {
        return implode("\n", $this->logs); // Retorna todos os logs formatados
    }
}
