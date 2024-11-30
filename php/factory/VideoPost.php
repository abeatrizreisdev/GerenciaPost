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

    }
    public function readPost($conteudo)
    {
        // A variável $conteudo é passada para a consulta SQL corretamente
        $db = Database::getInstance();
        $sql = "SELECT id, texto, 'video' AS tipo, video_url FROM videoPost WHERE texto LIKE :conteudo";
        $stmt = $db->prepare($sql);
        $stmt->execute([':conteudo' => "%" . $conteudo . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editarPost($texto, $videoUrl, $imagemUrl) {
        try {
            // Obter a instância da conexão com o banco de dados
            $db = Database::getInstance();
            
            // Iniciar a transação
            $db->beginTransaction();
            
            // Atualizar tabela 'posts' com 'texto' e 'video_url'
            $query = "UPDATE posts SET texto = :texto, video_url = :video WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':texto', $texto);
            $stmt->bindParam(':video', $videoUrl);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Atualizar tabela 'imagepost' com 'texto' e 'video_url'
            $query = "UPDATE videoPost SET texto = :texto, video_url = :video WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':texto', $texto);
            $stmt->bindParam(':video', $videoUrl);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Finalizar a transação
            $db->commit();
        } catch (PDOException $e) {
            // Reverter as alterações em caso de erro
            $db->rollBack();
            echo "Erro: " . $e->getMessage();
        }
    }
    

    public function salvarPost()
    {
    }

    public function deletePost() {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $stmt = $db->prepare("DELETE FROM videoPost WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

}
