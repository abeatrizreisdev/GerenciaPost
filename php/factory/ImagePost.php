<?php
require_once 'Post.php';

class ImagePost extends Post
{

    public $id;
    public $imagemUrl;
    public $texto;


    public function __construct($id = null, $texto, $imagemUrl, PostStrategy $strategy)
    {
        parent::__construct($strategy);
        $this->id = $id;
        $this->texto = $texto;
        $this->imagemUrl = $imagemUrl;
    }

    // Getter e Setter para 'imagemUrl'
    public function getImagemUrl()
    {
        return $this->imagemUrl;
    }

    public function setImagemUrl($imagemUrl)
    {
        $this->imagemUrl = $imagemUrl;
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

    // Getter e Setter para 'id'
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
        try {
            // Obter a conexão diretamente do Singleton
            $db = Database::getInstance();

            // Inserir o post na tabela 'posts', incluindo tipo, texto, imagem_url e video_url
            $query = "INSERT INTO posts (tipo, texto, imagem_url, video_url) VALUES ('image', ?, ?, NULL)";
            $stmt = $db->prepare($query);
            $stmt->execute([$this->texto, $this->imagemUrl]); // Inserir o texto e imagem_url

            // Obter o ID do post recém-criado
            $postId = $db->lastInsertId();

            // Inserir os dados na tabela 'imagePost' (a tabela de detalhes da imagem)
            $query = "INSERT INTO imagePost (id, imagem_url, texto) VALUES (?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$postId, $this->imagemUrl, $this->texto]);

            // Exibir a URL da imagem para confirmar a inserção
            echo "Imagem salva no banco de dados: " . $this->imagemUrl . "<br>";
        } catch (Exception $e) {
            // Exibir erro caso algo dê errado
            echo "Erro ao salvar o post no banco de dados: " . $e->getMessage() . "<br>";
        }
    }

    public function readPost()
    {

    }
    public function editarPost($novoTexto, $novaImagemUrl = null, $novoVideoUrl = null)
    {
        // Atualiza o texto
        $this->setTexto($novoTexto);

        // Atualiza a imagem, se fornecida
        if ($novaImagemUrl) {
            $this->setImagemUrl($novaImagemUrl);
        }

        // Agora, faz o update no banco de dados (método para salvar a atualização no banco)
        $this->salvarPost();
    }

    // Método para salvar a alteração no banco de dados
    public function salvarPost()
    {
        $db = Database::getInstance();
        $sql = "UPDATE imagePost SET texto = :texto, imagem_url = :imagem_url WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':texto', $this->getTexto());
        $stmt->bindParam(':imagem_url', $this->getImagemUrl());
        $stmt->bindParam(':id', $this->getId());

        if ($stmt->execute()) {
            echo "Post de imagem atualizado com sucesso!";
        } else {
            throw new Exception("Erro ao atualizar o post de imagem.");
        }
    }
    public function deletePost()
    {

    }

}
