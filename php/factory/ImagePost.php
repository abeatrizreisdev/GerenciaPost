<?php
require_once 'Post.php';

class ImagePost extends Post {
    public $imagemUrl;
    public $texto;

    public function __construct($imagemUrl, $texto = null, $id = null, PostStrategy $strategy) {
        parent::__construct($strategy, $id); // Passa o ID para a classe base
        $this->imagemUrl = $imagemUrl;
        $this->texto = $texto;
    }
    public function getImagemUrl() {
        return $this->imagemUrl;
    }

    public function setImagemUrl($imagemUrl) {
        $this->imagemUrl = $imagemUrl;
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
        $query = "INSERT INTO posts (tipo, texto, imagem_url) VALUES ('image', ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$this->texto, $this->imagemUrl]); // Inserir o texto e a imagem_url
    
        // Obter o ID do post recém-criado
        $postId = $db->lastInsertId();
    
        // Inserir os dados na tabela 'imagePost' (a tabela de detalhes da imagem)
        $query = "INSERT INTO imagePost (id_post, imagem_url, texto) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$postId, $this->imagemUrl, $this->texto]);
    
        // Exibir a URL da imagem para confirmar a inserção
        echo "Imagem salva no banco de dados: " . $this->imagemUrl . "<br>";
    }
    public function readPost(){
        
    }
    public function updatePost(){

    }

    public function deletePost(){
        
    }
    
}
