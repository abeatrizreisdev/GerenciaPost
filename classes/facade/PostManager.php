<?php
require_once ('../classes/factory/PostFactory.php');
require_once ('../classes/observer/PostLogger.php');

class PostManager {
    private $logger;

    public function __construct() {
        // Inicializando o logger para registrar os eventos
        $this->logger = new PostLogger();
    }

    // Método para criar um post
    public function createPost($type, $content) {
        // Criando o post com base no tipo
        $post = PostFactory::createPost($type);
        $post->setContent($content);
        
        // Salvando o post no banco de dados
        $post->saveToDatabase();
        
        // Notificando o log (observer) com a criação do post
        $this->logger->update($post, 'created');

        return $post;
    }

    // Método para atualizar o conteúdo de um post
    public function updatePost($post, $newContent) {
        // Atualizando o conteúdo do post
        $post->setContent($newContent);

        // Atualizando o post no banco de dados
        $post->updateInDatabase();

        // Notificando o log (observer) com a atualização do post
        $this->logger->update($post, 'updated');

        return $post;
    }

    // Método para excluir um post
    public function deletePost($post) {
        // Excluindo o post do banco de dados
        $post->deleteFromDatabase();

        // Notificando o log (observer) com a exclusão do post
        $this->logger->update($post, 'deleted');

        return $post;
    }
}
