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
    public function log($message) {
        // Aqui você pode escolher como deseja fazer o log (arquivo, banco de dados, etc.)
        error_log($message); // Exemplo de log no arquivo de erro padrão
    }
    private function generateLogMessage(Post $post, $event) {
        $timestamp = date('Y-m-d H:i:s');
        $postType = get_class($post);
        
        if ($post instanceof TextPost) {
            $conteudo = $post->getTexto();
        } elseif ($post instanceof ImagePost) {
            $conteudo = $post->getImagemUrl();
        } elseif ($post instanceof VideoPost) {
            $conteudo = $post->getVideoUrl();
        } else {
            $conteudo = 'Desconhecido';
        }
        
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
