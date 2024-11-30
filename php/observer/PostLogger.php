<?php

require_once __DIR__ . "/PostObserver.php";

class PostLogger implements PostObserver {
    private $logs = []; // Armazena as mensagens de log

    // Atualiza os logs com base no evento e no tipo de post
    public function update(Post $post, $event) {
        $message = $this->generateLogMessage($post, $event);
        $this->logs[] = $message; // Adiciona a mensagem ao log

        // Exibe a notificação bonita utilizando Toastr (se estiver configurado no frontend)
        echo "<script>showNotification('$message', '$event');</script>";
    }

    // Gera a mensagem de log com base no tipo de post e evento
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
            case 'updated':
                return "[$timestamp] Post atualizado: $postType - $conteudo";
            case 'deleted':
                return "[$timestamp] Post excluído: $postType - $conteudo";
            default:
                return "[$timestamp] Evento desconhecido.";
        }
    }

    // Retorna todos os logs registrados
    public function getLogs() {
        return implode("\n", $this->logs); // Retorna todos os logs formatados
    }
}
