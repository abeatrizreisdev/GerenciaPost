<?php
require_once 'Post.php';

class VideoPost extends Post {
    public $video_url;
    public $texto;

    public function __construct($video_url, $texto = null) {
        $this->video_url = $video_url;
        $this->texto = $texto;
    }

    public function saveToDatabase() {
        $db = Database::getInstance();
        
        // Inserir o post na tabela 'posts'
        $query = "INSERT INTO posts (tipo) VALUES ('video')";
        $stmt = $db->prepare($query);
        $stmt->execute();

        // Obter o ID do post recém-criado
        $postId = $db->lastInsertId();

        // Inserir os dados do vídeo na tabela 'videoPost'
        $query = "INSERT INTO videoPost (id_post, video_url, texto) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$postId, $this->video_url, $this->texto]);

        echo "Vídeo salvo no banco de dados: " . $this->video_url . "\n";
    }
}
