<?php
require_once __DIR__ . '/../strategy/PostStrategy.php';

class VideoPostStrategy implements PostStrategy {
    public function display(Post $post) {
        $id = htmlspecialchars($post->getId());
        $conteudo = htmlspecialchars($post->getConteudo());  // Conteúdo genérico (texto)

        // Verifica se o post é uma instância de VideoPost e acessa o URL do vídeo
        if ($post instanceof VideoPost) {
            $videoUrl = htmlspecialchars($post->getVideoUrl());
            $html = "<h3>Vídeo</h3>";
            $html .= "<p>ID do Post: " . $id . "</p>";
            $html .= "<p>Conteúdo: " . $conteudo . "</p>";  // Exibe o conteúdo genérico (texto)
            $html .= "<video controls><source src='" . $videoUrl . "' type='video/mp4'></video>";  // Exibe o vídeo
        }

        return $html;
    }
}

?>
