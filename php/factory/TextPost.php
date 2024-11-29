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

            // Inserir na tabela 'posts'
            $query = "INSERT INTO posts (tipo) VALUES ('text')";
            $stmt = $db->prepare($query);
            $stmt->execute();

            $postId = $db->lastInsertId();

            // Inserir na tabela 'textPost'
            $query = "INSERT INTO textPost (id_post, texto) VALUES (?, ?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$postId, $this->texto]);

            echo "Post salvo no banco de dados: " . $this->texto . "\n";
        } catch (Exception $e) {
            echo "Erro ao salvar o post no banco de dados: " . $e->getMessage() . "\n";
        }
    }


    public function updatePost()
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE textPost SET texto = :texto WHERE id = :id");
        $stmt->bindValue(':texto', $this->getTexto());
        $stmt->bindValue(':id', $this->getId());
        $stmt->execute();
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
