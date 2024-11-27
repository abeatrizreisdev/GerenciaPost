<?php
require_once 'Post.php';

class TextPost extends Post
{
    public $id;
    public $texto;
    protected $dataCriacao;
    protected $dataAtualizacao;
    // Agora o construtor aceita o ID como parâmetro
    public function __construct($texto, $id, PostStrategy $strategy, $dataCriacao, $dataAtualizacao ){
        parent::__construct($strategy);  // Passa a estratégia para a classe pai
        $this->id = $id;
        $this->texto = $texto;
        $this->dataCriacao = $dataCriacao;
        $this->dataAtualizacao = $dataAtualizacao;
    }
    // Getter e Setter para 'texto'
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getTexto()
    {
        return $this->texto;
    }
    public function setTexto($conteudo)
    {
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

    public function saveToDatabase()
    {
        try {
            // Obter a instância do banco de dados
            $db = Database::getInstance();

            // Inserir o post na tabela 'posts'
            $query = "INSERT INTO posts (tipo, texto, data_criacao, data_atualizacao) VALUES ('text', ?, NOW(), NOW())";
            $stmt = $db->prepare($query);

            // Executar a consulta com o URL da imagem
            $stmt->execute([$this->texto]);

            echo "Post salvo no banco de dados: " . $this->texto . "\n";
        } catch (Exception $e) {
            // Tratar possíveis erros
            echo "Erro ao salvar o post no banco de dados: " . $e->getMessage() . "\n";
        }
    }

    public function updatePost()
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE textPost SET texto = :texto WHERE id = :id");
        $stmt->bindValue(':texto', $this->getConteudo());
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
