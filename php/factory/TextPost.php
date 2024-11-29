<?php
require_once 'Post.php';

class TextPost extends Post
{
    public $id;
    public $texto;

    // Agora o construtor aceita o ID como parâmetro
    public function __construct($texto, $id, PostStrategy $strategy)
    {
        parent::__construct($strategy);
        $this->texto = $texto;
        $this->id = $id;

    }
    // Getter e Setter para 'texto'
    public function getTexto()
    {
        return $this->texto;
    }
    public function setTexto($conteudo)
    {
        $this->texto = $conteudo;
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
    try {
        // Debug: Verificar conteúdo antes de salvar
        error_log("Tentando salvar o texto: " . $this->texto);

        $db = Database::getInstance();

        // Inserir na tabela 'posts' (tabela principal)
        $query = "INSERT INTO posts (tipo, texto, imagem_url, video_url) VALUES ('text', ?, NULL, NULL)";
        $stmt = $db->prepare($query);
        $stmt->execute([$this->texto]);

        // Obter o ID do post inserido
        $postId = $db->lastInsertId();

        // Agora você pode opcionalmente inserir o texto na tabela textPost, se desejar
        $query = "INSERT INTO textPost (id, texto) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$postId, $this->texto]);

        echo "Post salvo no banco de dados: " . $this->texto . "\n";
    } catch (Exception $e) {
        echo "Erro ao salvar o post no banco de dados: " . $e->getMessage() . "\n";
    }
}



    public function editarPost($novoTexto, $novaImagemUrl = null, $novoVideoUrl = null)
    {
        // Atualiza o texto do post
        $this->texto = $novoTexto;

        $this->salvarPost();
    }

    public function salvarPost()
    {
        $db = Database::getInstance();
        $sql = "UPDATE textPost SET texto = :texto WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':texto', $this->getTexto());
        $stmt->bindParam(':id', $this->getId());

        if ($stmt->execute()) {
            echo "Post de texto atualizado com sucesso!";
        } else {
            throw new Exception("Erro ao atualizar o post de texto.");
        }
    }

    public function readPost()
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM textPost WHERE id = :id");
        $stmt->bindValue(':id', $this->getId());
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletePost()
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM textPost WHERE id = :id");
        $stmt->bindValue(':id', $this->getId());
        $stmt->execute();
    }


}
