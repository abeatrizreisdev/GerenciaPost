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

    } catch (Exception $e) {
        echo "Erro ao salvar o post no banco de dados: " . $e->getMessage() . "\n";
    }
}



public function editarPost($texto, $videoUrl, $imagemUrl) {
    try {
        // Obter a instância da conexão com o banco de dados
        $db = Database::getInstance();
        
        // Iniciar a transação
        $db->beginTransaction();
        
        // Atualizar tabela 'posts' com 'texto'
        $query = "UPDATE posts SET texto = :texto WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':texto', $texto);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Atualizar tabela 'imagepost' com 'texto'
        $query = "UPDATE textPost SET texto = :texto WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':texto', $texto);
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

    public function readPost($conteudo)
    {
        // Garantindo que a variável $conteudo seja definida e usada corretamente
        $db = Database::getInstance();
        $sql = "SELECT id, texto, 'text' AS tipo FROM textPost WHERE texto LIKE :conteudo";
        $stmt = $db->prepare($sql);
        $stmt->execute([':conteudo' => "%" . $conteudo . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deletePost() {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $stmt = $db->prepare("DELETE FROM textPost WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }



}
