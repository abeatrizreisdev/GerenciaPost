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

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id; // Retorna o valor da propriedade $id
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

        } catch (Exception $e) {
            // Exibir erro caso algo dê errado
            echo "Erro ao salvar o post no banco de dados: " . $e->getMessage() . "<br>";
        }
    }

    public function readPost($conteudo)
    {
        // A variável $conteudo é passada para a consulta SQL corretamente
        $db = Database::getInstance();
        $sql = "SELECT id, texto, 'image' AS tipo, imagem_url FROM imagePost WHERE texto LIKE :conteudo";
        $stmt = $db->prepare($sql);
        $stmt->execute([':conteudo' => "%" . $conteudo . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function editarPost($texto, $videoUrl, $imagemUrl)
    {
        try {
            // Obter a instância da conexão com o banco de dados
            $db = Database::getInstance();

            // Iniciar a transação
            $db->beginTransaction();

            // Atualizar tabela 'posts' com 'texto' e 'imagem_url'
            $query = "UPDATE posts SET texto = :texto, imagem_url = :imagem WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':texto', $texto);
            $stmt->bindParam(':imagem', $imagemUrl);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();

            // Atualizar tabela 'imagepost' com 'texto' e 'imagem_url'
            $query = "UPDATE imagePost SET texto = :texto, imagem_url = :imagem WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':texto', $texto);
            $stmt->bindParam(':imagem', $imagemUrl);
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

    public function deletePost()
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $stmt = $db->prepare("DELETE FROM imagePost WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

}
