<?php
require_once('../classes/observer/PostObserver.php'); // Incluindo a interface PostObserver

class PostLogger implements PostObserver {
    // Método para receber a notificação do Observer
    public function update(Post $post, $event) {
        $message = $this->generateLogMessage($post, $event);
        
        // Exibindo a mensagem via echo
        echo $message;
    }

    // Gera a mensagem de log dependendo do tipo de evento
    private function generateLogMessage(Post $post, $event) {
        $timestamp = date('Y-m-d H:i:s'); // Data e hora atual
        $postType = get_class($post); // Tipo de post (ex: TextPost, ImagePost)
        $content = $post->getContent(); // Conteúdo do post

        // Gerando a mensagem de log com base no evento
        switch ($event) {
            case 'created':
                return "[$timestamp] Novo post criado: $postType com conteúdo: $content\n";
            case 'updated':
                return "[$timestamp] Post atualizado: $postType com novo conteúdo: $content\n";
            case 'deleted':
                return "[$timestamp] Post excluído: $postType com conteúdo: $content\n";
            default:
                return "[$timestamp] Evento desconhecido.\n";
        }
    }
}
