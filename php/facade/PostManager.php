<?php
require_once __DIR__ . "/../factory/PostFactory.php";
require_once __DIR__ . "/../observer/PostLogger.php";


class PostManager {
    private $logger;

    // Agora o construtor recebe um logger como parâmetro
    public function __construct(PostLogger $logger) {
        $this->logger = $logger;
    }

    public function createPost($type, $content, $imagemUrl = null, $videoUrl = null) {
        // Cria o post através da fábrica com todos os parâmetros necessários
        $post = PostFactory::createPost($type, $content, $imagemUrl, $videoUrl);
        $post->saveToDatabase();
    
        // Registra o evento no logger
        $this->logger->update($post, 'created');
    
        return $post;
    }
    public function readPost($searchTerm = '', $searchType = '') {
        // Conectar ao banco de dados
        $db = Database::getInstance();

        // Construção da query
        $sql = "SELECT * FROM posts WHERE 1=1"; // 1=1 é uma técnica para facilitar a concatenação de condições

        // Filtrando por termo de pesquisa, se presente
        if (!empty($searchTerm)) {
            $searchTerm = "%" . $db->quote($searchTerm) . "%";  // Evitar SQL injection
            $sql .= " AND conteudo LIKE $searchTerm";
        }

        // Filtrando por tipo de post, se presente
        if (!empty($searchType)) {
            $sql .= " AND tipo = $searchType";
        }

        // Executando a consulta
        $stmt = $db->query($sql);

        // Criando a lista de posts
        $posts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Usando a PostFactory para criar o post com base no tipo
            $posts[] = PostFactory::createPost($row);
        }

        return $posts;
    }

    public function updatePost($post, $newContent) {
        $post->setContent($newContent);
        $post->updateInDatabase();
        $this->logger->update($post, 'updated');  // Registra o log de atualização

        return $post;
    }

    public function deletePost($post) {
        $post->deleteFromDatabase();
        $this->logger->update($post, 'deleted');  // Registra o log de exclusão

        return $post;
    }

    // Retorna os logs registrados
    public function getLogs() {
        return $this->logger->getLogs();
    }
}

