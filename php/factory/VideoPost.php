<?php
require_once 'Post.php';

class VideoPost extends Post
{

    public $id;
    public $videoUrl;
    public $texto;

    public function __construct($videoUrl, $texto, $id, PostStrategy $strategy)
    {
        parent::__construct($strategy);
        $this->videoUrl = $videoUrl;
        $this->texto = $texto;
        $this->id = $id;
    }
    public function getVideoUrl()
    {
        return $this->videoUrl;
    }

    public function setVideoUrl($videoUrl)
    {
        $this->videoUrl = $videoUrl;
    }

    // Getter e Setter para 'texto'
    public function getTexto()
    {
        return $this->texto;
    }

    public function setTexto($texto)
    {
        $this->texto = $texto;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


    public function saveToDatabase()
    {
        $db = Database::getInstance();

        // Inserir o post na tabela 'posts' (você precisa passar os parâmetros corretamente)
        $query = "INSERT INTO posts (tipo, texto, imagem_url, video_url) VALUES ('video', ?, NULL, ?)";
        $stmt = $db->prepare($query);

        // A consulta espera 2 parâmetros (texto e video_url)
        $stmt->execute([$this->texto, $this->videoUrl]);

        // Obter o ID do post recém-criado
        $postId = $db->lastInsertId();

        // Inserir os dados do vídeo na tabela 'videoPost'
        $query = "INSERT INTO videoPost (id, video_url, texto) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);

        // Passando os valores corretamente
        $stmt->execute([$postId, $this->videoUrl, $this->texto]);

        echo "Vídeo salvo no banco de dados: " . $this->videoUrl . "\n";
    }
    public function readPost()
    {

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
    }

    public function deletePost()
    {

    }

}
