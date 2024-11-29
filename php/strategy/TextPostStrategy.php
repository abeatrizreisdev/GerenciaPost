<?php
require_once __DIR__ . '/../strategy/PostStrategy.php';
require_once __DIR__ . '/../factory/TextPost.php';
require_once __DIR__ . '/../factory/Post.php';


class TextPostStrategy implements PostStrategy {
    public function display(Post $post)
    {
        // Verifica se o post é uma instância de ImagePost e acessa o URL da imagem
        if ($post instanceof TextPost) {
            $conteudo = htmlspecialchars($post->getTexto());  // Conteúdo genérico (texto)
            $id = htmlspecialchars($post->getId());  // Conteúdo genérico (texto)
            $html = "<h3 id='tituloTexto'>Post do tipo Texto com ID ". $id."</h3>";
            $html .= "<p id='conteudoTexto'>" . $conteudo . "</p>";  // Exibe o conteúdo genérico (texto)
        }
        return $html;
    }
}
?>
