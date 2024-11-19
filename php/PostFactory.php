<?php
require_once __DIR__ .'./Post.php';
require_once  ('./PostStrategy.php');
require_once  ('./TextPostStrategy.php');
require_once  ('./ImagePostStrategy.php');
require_once  ('./VideoPostStrategy.php');

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
