<?php
require_once('PostObserver.php'); // Incluindo a interface PostObserver

class PostLogger implements PostObserver {
    private $logs = []; // Armazena as mensagens de log

    public function update(Post $post, $event) {
        $message = $this->generateLogMessage($post, $event);
        $this->logs[] = $message; // Adiciona a mensagem ao log
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
                return "[$timestamp] Novo post criado: $postType - $conteudo";
            default:
                return "[$timestamp] Evento desconhecido.";
        }
    }

    public function getLogs() {
        return implode("\n", $this->logs); // Retorna todos os logs formatados
    }
}
