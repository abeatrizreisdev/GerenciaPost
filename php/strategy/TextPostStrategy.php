<?php
require_once __DIR__ . '/../strategy/PostStrategy.php';
require_once __DIR__ . '/../factory/TextPost.php';
require_once __DIR__ . '/../factory/Post.php';


class TextPostStrategy implements PostStrategy {
    public function display(Post $post) {
        $html = "<h3>Texto</h3>";
        $html .= "<p>ID do Post: " . htmlspecialchars($post->getId()) . "</p>";
        $html .= "<p>Conteúdo: " . htmlspecialchars($post->getConteudo()) . "</p>";  // Exibe o conteúdo (texto)
        
        return $html;
    }
}
?>
