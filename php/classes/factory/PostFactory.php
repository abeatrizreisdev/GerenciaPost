<?php
include_once 'Post.php';
include_once  ('../strategy/PostStrategy.php');
include_once  ('../strategy/TextPostStrategy.php');
include_once  ('../strategy/ImagePostStrategy.php');
include_once  ('../strategy/VideoPostStrategy.php');
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
