<?php
require_once 'Post.php';

class VideoPost extends Post {
    public $id;
    public $videoUrl;
    public $texto;
    protected $dataCriacao;
    protected $dataAtualizacao;

    public function __construct($id, $videoUrl, $texto = null,$dataCriacao, $dataAtualizacao, PostStrategy $strategy) {
        parent::__construct($strategy);
        $this->id = $id;
        $this->videoUrl = $videoUrl;
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

    // Getter e Setter para 'texto'
    public function getTexto() {
        return $this->texto;
    }
    public function setTexto($conteudo) {
        $this->texto = $conteudo;
    }

    public function getVideoUrl() {
        return $this->videoUrl;
    }
    public function setVideoUrl($videoUrl) {
        $this->videoUrl = $videoUrl;
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
