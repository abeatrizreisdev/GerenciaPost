<?php
require_once 'Post.php';

class ImagePost extends Post {
    public $id;
    public $imagemUrl;
    public $texto;
    protected $dataCriacao;
    protected $dataAtualizacao;

    public function __construct($id, $imagemUrl, $texto = null, $dataCriacao, $dataAtualizacao, PostStrategy $strategy) {
        parent::__construct($strategy);
        $this->id = $id;
        $this->imagemUrl = $imagemUrl;
        $this->texto = $texto;
        $this->dataCriacao = $dataCriacao;
        $this->dataAtualizacao = $dataAtualizacao;
    }
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
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

    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;

    }public function getDataAtualizacao()
    {
        return $this->dataAtualizacao;
    }
    public function setDataAtualizacao($dataAtualizacao)
    {
        $this->texto = $dataAtualizacao;
    }


    public function saveToDatabase() {
        // Obter a conexão diretamente do Singleton
        $db = Database::getInstance();
    
        // Inserir o post na tabela 'posts', incluindo imagem_url e texto
        $query = "INSERT INTO posts (tipo, texto, imagem_url,data_criacao, data_atualizacao) VALUES ('image', ?, ?,NOW(), NOW())";
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
