<?php
require_once __DIR__ . '/../strategy/PostStrategy.php';

class VideoPostStrategy implements PostStrategy {
    public function display(Post $post)
    {
        // Verifica se o post é uma instância de ImagePost e acessa o URL da imagem
        if ($post instanceof VideoPost) {
            $videoUrl = htmlspecialchars($post->getVideoUrl());
            $id = htmlspecialchars($post->getId());  // Conteúdo genérico (texto)
            $conteudo = htmlspecialchars($post->getTexto());  // Conteúdo genérico (texto)
            $html = "<h3 id='tituloVideo'>Post do tipo Video com ID ". $id . "</h3>";
            $html .= "<video id='videoPost' controls><source src='" . $videoUrl . "' type='video/mp4'></video>";  // Exibe o vídeo
            $html .= "<p id='conteudoVideo'>" . $conteudo . "</p>";  // Exibe o conteúdo genérico (texto)

        }
        return $html;
    }
}

?>
