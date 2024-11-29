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

    public function setTexto($texto) {
        $this->texto = $texto;
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
        $query = "INSERT INTO videoPost (id, video_url, texto) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        // Passando os valores para o execute
        $stmt->execute([$postId, $this->videoUrl, $this->texto]);
    
        echo "Vídeo salvo no banco de dados: " . $this->videoUrl . "\n";
    }
    public function readPost(){
        
    }
    public function editarPost($novoTexto, $novaImagemUrl = null, $novoVideoUrl = null)
    {
        // Atualiza o texto do post
        $this->texto = $novoTexto;
        
        // Se for fornecida uma nova URL de vídeo, atualiza a URL do vídeo
        if ($novoVideoUrl) {
            $this->videoUrl = $novoVideoUrl;
        }

        // Agora, faz o update no banco de dados
        $this->salvarPost();
    }

    public function salvarPost()
    {
        $db = Database::getInstance();
        $sql = "UPDATE videoPost SET texto = :texto, video_url = :video_url WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':texto', $this->getTexto());
        $stmt->bindParam(':video_url', $this->getVideoUrl());
        $stmt->bindParam(':id', $this->getId());

        if ($stmt->execute()) {
            echo "Post de vídeo atualizado com sucesso!";
        } else {
            throw new Exception("Erro ao atualizar o post de vídeo.");
        }
    }

    public function deletePost(){
        
    }
    
}
