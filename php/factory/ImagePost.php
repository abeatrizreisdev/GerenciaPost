<?php
require_once 'Post.php';

class ImagePost extends Post {
    public $imagem_url;
    public $texto;

    public function __construct($imagem_url, $texto = null) {
        $this->imagem_url = $imagem_url;
        $this->texto = $texto;
    }

    public function saveToDatabase() {
        // Obter a conexão diretamente do Singleton
        $db = Database::getInstance();
        
        // Inserir o post na tabela 'posts'
        $query = "INSERT INTO posts (tipo) VALUES ('image')";
        $stmt = $db->prepare($query);
        $stmt->execute();

        // Obter o ID do post recém-criado
        $postId = $db->lastInsertId();

        // Inserir os dados da imagem na tabela 'imagePost'
        $query = "INSERT INTO imagePost (id_post, imagem_url, texto) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$postId, $this->imagem_url, $this->texto]);

        echo "Imagem salva no banco de dados: " . $this->imagem_url . "<br>";
    }
}
