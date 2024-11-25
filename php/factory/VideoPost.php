<?php
require_once 'Post.php';

class VideoPost extends Post {
    public $videoUrl;
    public $texto;

    public function __construct($videoUrl, $texto = null, $id = null) {
        parent::__construct(null, $id);
        $this->videoUrl = $videoUrl;
        $this->texto = $texto;
    }
    public function getVideoUrl() {
        return $this->videoUrl;
    }

    public function setVideoUrl($videoUrl) {
        $this->videoUrl = $videoUrl;
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
        $stmt->execute([$this->videoUrl, $this->texto]);
    
        // Obter o ID do post recém-criado
        $postId = $db->lastInsertId();
    
        // Inserir os dados do vídeo na tabela 'videoPost'
        $query = "INSERT INTO videoPost (id_post, video_url, texto) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        // Passando os valores para o execute
        $stmt->execute([$postId, $this->videoUrl, $this->texto]);
    
        echo "Vídeo salvo no banco de dados: " . $this->videoUrl . "\n";
    }
    public function readPost(){
        
    }
    public function updatePost(){

    }

    public function deletePost(){
        
    }
    
}
