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
    public static function createPost($tipo, $id, $conteudo = null, $imagemUrl = null, $videoUrl = null,$dataCriacao = null, $dataAtualizacao = null) {
        if ($tipo == 'text') {
            return new TextPost($conteudo, null, new TextPostStrategy(), $dataCriacao, $dataAtualizacao);  // Sem imagem e sem vídeo
        } elseif ($tipo == 'image') {
            return new ImagePost($id,$imagemUrl, $conteudo,$dataCriacao, $dataAtualizacao, new ImagePostStrategy());  // Passa imagemUrl
        } elseif ($tipo == 'video') {
            return new VideoPost($id,$videoUrl, $conteudo,$dataCriacao, $dataAtualizacao, new VideoPostStrategy());  // Passa videoUrl
        } else {
            throw new Exception("Tipo de post inválido");
        }
    }
    
}
