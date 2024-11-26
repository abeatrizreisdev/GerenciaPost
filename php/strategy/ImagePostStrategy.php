<?php
require_once __DIR__ . '/../strategy/PostStrategy.php';

class ImagePostStrategy implements PostStrategy {
    public function display(Post $post) {
        $id = htmlspecialchars($post->getId());
        $conteudo = htmlspecialchars($post->getConteudo());  // Conteúdo genérico (texto)

        // Verifica se o post é uma instância de ImagePost e acessa o URL da imagem
        if ($post instanceof ImagePost) {
            $imageUrl = htmlspecialchars($post->getImagemUrl());
            $html = "<h3>Imagem</h3>";
            $html .= "<p>ID do Post: " . $id     . "</p>";
            $html .= "<p>Conteúdo: " . $conteudo . "</p>";  // Exibe o conteúdo genérico (texto)
            $html .= "<img src='" . $imageUrl . "' alt='Imagem do post' />";  // Exibe a imagem
        }

        return $html;
    }
}
?>
