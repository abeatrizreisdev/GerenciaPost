<?php
require_once __DIR__ . '/../strategy/PostStrategy.php';

class VideoPostStrategy implements PostStrategy {
    public function display(Post $post)
    {
        // Verifica se o post é uma instância de ImagePost e acessa o URL da imagem
        if ($post instanceof VideoPost) {
            $videoUrl = htmlspecialchars($post->getVideoUrl());
            $conteudo = htmlspecialchars($post->getTexto());  // Conteúdo genérico (texto)
            $html = "<h3>Video</h3>";
            $html .= "<p>Conteúdo: " . $conteudo . "</p>";  // Exibe o conteúdo genérico (texto)
            $html .= "<video controls><source src='" . $videoUrl . "' type='video/mp4'></video>";  // Exibe o vídeo
        }
        return $html;
    }
}

?>
