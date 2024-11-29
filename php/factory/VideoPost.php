<?php
require_once 'Post.php';

class VideoPost extends Post {

    public $id;
    public $videoUrl;
    public $texto;

    public function __construct($videoUrl, $texto, $id, PostStrategy $strategy) {
        parent::__construct($strategy);
        $this->videoUrl = $videoUrl;
        $this->texto = $texto;
        $this->id = $id;
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
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
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
