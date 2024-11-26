<?php
require_once __DIR__ . '/../strategy/PostStrategy.php';

class ImagePostStrategy implements PostStrategy {
    public function display(Post $post) {
        $html = "<h3>Imagem</h3>";
        $html .= "<p>ID do Post: " . htmlspecialchars($post->getId()) . "</p>";
        $html .= "<p>Conteúdo: " . htmlspecialchars($post->getConteudo()) . "</p>";  // Exibe o conteúdo (imagem URL)
        $html .= "<img src='" . htmlspecialchars($post->getConteudo()) . "' alt='Imagem do Post' style='max-width: 100%;'>";
        
        return $html;
    }
}
?>
