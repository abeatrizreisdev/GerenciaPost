<?php
require_once __DIR__ . '/../strategy/PostStrategy.php';

class VideoPostStrategy implements PostStrategy {
    public function display(Post $post) {
        $html = "<h3>Vídeo</h3>";
        $html .= "<p>ID do Post: " . htmlspecialchars($post->getId()) . "</p>";
        $html .= "<p>Conteúdo: " . htmlspecialchars($post->getConteudo()) . "</p>";  // Exibe o conteúdo (video URL)
        $html .= "<video controls><source src='" . htmlspecialchars($post->getConteudo()) . "' type='video/mp4'></video>";
        
        return $html;
    }
}
?>
