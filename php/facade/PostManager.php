<?php
require_once __DIR__ . "/../factory/PostFactory.php";
require_once __DIR__ . "/../observer/PostLogger.php";


class PostManager {
    private $logger;

    // Agora o construtor recebe um logger como parâmetro
    public function __construct(PostLogger $logger) {
        $this->logger = $logger;
    }

    public function createPost($type, $content) {
        // Cria o post através da fábrica
        $post = PostFactory::createPost($type);
        $post->setContent($content);  // Define o conteúdo do post
        $post->saveToDatabase();  // Salva no banco de dados
        
        // Registra o log de criação
        $this->logger->update($post, 'created');
    
        // Verificando os logs no debug
        var_dump($this->logger->getLogs());
    
        return $post;
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

