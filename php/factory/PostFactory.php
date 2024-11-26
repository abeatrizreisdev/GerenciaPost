<?php
require_once __DIR__ .'/../factory/Post.php';
require_once __DIR__ .  ('/../factory/Post.php');
require_once __DIR__ .  ('/../factory/TextPost.php');
require_once __DIR__ .  ('/../factory/ImagePost.php');
require_once __DIR__ .  ('/../factory/VideoPost.php');
require_once __DIR__ .  ('/../strategy/PostStrategy.php');
require_once __DIR__ .  ('/../strategy/TextPostStrategy.php');
require_once __DIR__ .  ('/../strategy/ImagePostStrategy.php');
require_once __DIR__ .  ('/../strategy/VideoPostStrategy.php');

class PostFactory {
    public static function createPost($tipo, $conteudo = null, $imagemUrl = null, $videoUrl = null) {
        if ($tipo == 'text') {
            return new TextPost($conteudo, null, new TextPostStrategy());  // Sem imagem e sem vídeo
        } elseif ($tipo == 'image') {
            return new ImagePost($imagemUrl, $conteudo, null, new ImagePostStrategy());  // Passa imagemUrl
        } elseif ($tipo == 'video') {
            return new VideoPost($videoUrl, $conteudo, null, new VideoPostStrategy());  // Passa videoUrl
        } else {
            throw new Exception("Tipo de post inválido");
        }
    }
    
}
