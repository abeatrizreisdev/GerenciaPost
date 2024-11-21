<?php
require_once 'Post.php';

class ImagePost extends Post {
    public $imagem_url;
    public $texto;

    public function __construct($imagem_url, $texto = null) {
        $this->imagem_url = $imagem_url;
        $this->texto = $texto;
    }
    public function getImagemUrl() {
        return $this->imagem_url;
    }

    public function setImagemUrl($imagem_url) {
        $this->imagem_url = $imagem_url;
    }

    // Getter e Setter para 'texto'
    public function getTexto() {
        return $this->texto;
    }

    public function setTexto($conteudo) {
        $this->texto = $conteudo;
    }
    public function saveToDatabase() {
        // Obter a conexão diretamente do Singleton
        $db = Database::getInstance();
    
        // Inserir o post na tabela 'posts', incluindo imagem_url e texto
        $query = "INSERT INTO posts (tipo, texto, imagem_url,data_criacao, data_atualizacao) VALUES ('image', ?, ?,NOW(), NOW())";
        $stmt = $db->prepare($query);
        $stmt->execute([$this->texto, $this->imagem_url]); // Inserir o texto e a imagem_url
    
        // Obter o ID do post recém-criado
        $postId = $db->lastInsertId();
    
        // Inserir os dados na tabela 'imagePost' (a tabela de detalhes da imagem)
        $query = "INSERT INTO imagePost (id_post, imagem_url, texto) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$postId, $this->imagem_url, $this->texto]);
    
        // Exibir a URL da imagem para confirmar a inserção
        echo "Imagem salva no banco de dados: " . $this->imagem_url . "<br>";
    }
    
    public function updatePost(){

    }

    public function deletePost(){
        
    }
    
}
