<?php
require_once __DIR__ . '/../strategy/PostStrategy.php';

class ImagePostStrategy implements PostStrategy
{
    public function display(Post $post)
    {
        $dataCriacao = htmlspecialchars($post->getDataCriacao());  // Conteúdo genérico (texto)
        $dataAtualizacao = htmlspecialchars($post->getDataAtualizacao());  // Conteúdo genérico (texto)
        $dataAtualizacao = htmlspecialchars($post->getDataAtualizacao());  // Conteúdo genérico (texto)


        // Verifica se o post é uma instância de ImagePost e acessa o URL da imagem
        if ($post instanceof ImagePost) {
            $id = htmlspecialchars($post->getId());
            var_dump($id);
            $imageUrl = htmlspecialchars($post->getImagemUrl());
            $texto = htmlspecialchars($post->getTexto());  // Conteúdo genérico (texto)
            $html = "<h3>Imagem</h3>";
            $html .= "<p>ID do Post: " . $id . "</p>";
            $html .= "<p>Data Criação: " . $dataCriacao . "</p>";
            $html .= "<p>Ultima Atualização: " . $dataAtualizacao . "</p>";
            $html .= "<p>Conteúdo: " . $texto . "</p>";  // Exibe o conteúdo genérico (texto)
            $html .= "<img src='" . $imageUrl . "' alt='Imagem do post' />";  // Exibe a imagem
        }

        return $html;
    }
}
?>