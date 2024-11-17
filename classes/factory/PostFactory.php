<?php
require_once 'Post.php';
require_once ('../classes/strategy/PostStrategy.php');
require_once ('../classes/strategy/TextPostStrategy.php');
require_once ('../classes/strategy/ImagePostStrategy.php');
require_once ('../classes/strategy/VideoPostStrategy.php');

class PostFactory {
    public static function createPost($tipo, $conteudo = null, $imagemUrl = null, $videoUrl = null) {
        if ($tipo == 'text') {
            return new TextPost($conteudo);  // Sem título
        } elseif ($tipo == 'image') {
            return new ImagePost($imagemUrl, $conteudo);  // Sem título
        } elseif ($tipo == 'video') {
            return new VideoPost($videoUrl, $conteudo);  // Sem título
        } else {
            throw new Exception("Tipo de post inválido");
        }
    }
}
