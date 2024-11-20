<?php
require_once 'Post.php';

class TextPost extends Post {
    public $conteudo;

    public function __construct($conteudo) {
        $this->conteudo = $conteudo;
    }

    public function saveToDatabase() {
        $db = Database::getInstance();
        
        // Inserir o post na tabela 'posts'
        $query = "INSERT INTO posts (tipo) VALUES ('text')";
        $stmt = $db->prepare($query);
        $stmt->execute();

        // Obter o ID do post recém-criado
        $postId = $db->lastInsertId();

        // Inserir o conteúdo do texto na tabela 'textPost'
        $query = "INSERT INTO textPost (id_post, texto) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$postId, $this->conteudo]);

        echo "Texto salvo no banco de dados: " . $this->conteudo . "\n";
    }
}
