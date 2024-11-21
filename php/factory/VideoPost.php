<?php
require_once 'Post.php';

class VideoPost extends Post {
    public $video_url;
    public $texto;

    public function __construct($video_url, $texto = null) {
        $this->video_url = $video_url;
        $this->texto = $texto;
    }
    public function getVideo_url() {
        return $this->video_url;
    }

    public function setVideo_url($video_url) {
        $this->video_url = $video_url;
    }

    // Getter e Setter para 'texto'
    public function getTexto() {
        return $this->texto;
    }

    public function setTexto($conteudo) {
        $this->texto = $conteudo;
    }
    public function saveToDatabase() {
        $db = Database::getInstance();
        
        // Inserir o post na tabela 'posts'
        $query = "INSERT INTO posts (tipo, video_url, texto, data_criacao, data_atualizacao) VALUES ('video', ?, ?, NOW(), NOW())";
        $stmt = $db->prepare($query);
        // Passando os valores para o execute
        $stmt->execute([$this->video_url, $this->texto]);
    
        // Obter o ID do post recém-criado
        $postId = $db->lastInsertId();
    
        // Inserir os dados do vídeo na tabela 'videoPost'
        $query = "INSERT INTO videoPost (id_post, video_url, texto) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        // Passando os valores para o execute
        $stmt->execute([$postId, $this->video_url, $this->texto]);
    
        echo "Vídeo salvo no banco de dados: " . $this->video_url . "\n";
    }
    public function updatePost(){

    }

    public function deletePost(){
        
    }
    
}
