<?php
require_once __DIR__ . '/../strategy/PostStrategy.php';

class ImagePostStrategy implements PostStrategy
{
    public function display(Post $post)
    {
        // Verifica se o post é uma instância de ImagePost e acessa o URL da imagem
        if ($post instanceof ImagePost) {
            $id = htmlspecialchars($post->getId());
            $imageUrl = htmlspecialchars($post->getImagemUrl());
            $conteudo = htmlspecialchars($post->getTexto());  // Conteúdo genérico (texto)
            $html = "<h3 id='tituloImagem'>Post do tipo Imagem com o ID " . $id ."</h3>";
            $html .= "<p id='conteudoImagem'>" . $conteudo . "</p>";  // Exibe o conteúdo genérico (texto)
            $html .= "<img class='imagemPost' src='" . $imageUrl . "' alt='Imagem do post' />";  // Exibe a imagem
        }
        return $html;
    }
}
?>