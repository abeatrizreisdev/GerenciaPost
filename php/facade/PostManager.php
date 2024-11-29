<?php
require_once __DIR__ . "/../factory/PostFactory.php";
require_once __DIR__ . "/../observer/PostLogger.php";


class PostManager
{
    private $logger;

    // Agora o construtor recebe um logger como parâmetro
    public function __construct(PostLogger $logger)
    {
        $this->logger = $logger;
    }

    public function createPost($type, $content, $imagemUrl = null, $videoUrl = null)
    {
        $id = uniqid();  
        $post = PostFactory::createPost($type, $id, $content, $imagemUrl, $videoUrl);
        $post->saveToDatabase();
        
        $this->logger->update($post, 'created');

        return $post;
    }

    public function buscarTodosPosts()
    {
        try {
            $db = Database::getInstance();
            $sql = "SELECT * FROM posts";
            $stmt = $db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Usa o método log() para registrar a exceção
            $this->logger->log("Erro ao buscar todos os posts: " . $e->getMessage());
            return null;
        }
    }

    public function buscarPostsPorFiltro($tipo, $conteudo = '')
    {
        try {
            $db = Database::getInstance();
            $sql = "";
            $params = [];

            // Ajuste da consulta dependendo do tipo de filtro
            switch ($tipo) {
                case 'all':
                    $sql = "SELECT * FROM posts WHERE texto LIKE :conteudo";
                    break;
                case 'image':
                    $sql = "SELECT * FROM imagePost WHERE imagem_url LIKE :conteudo";
                    break;
                case 'text':
                    $sql = "SELECT * FROM textPost WHERE texto LIKE :conteudo";
                    break;
                case 'video':
                    $sql = "SELECT * FROM videoPost WHERE video_url LIKE :conteudo";
                    break;
                default:
                    throw new Exception("Tipo de filtro inválido: $tipo");
            }

            $params[':conteudo'] = '%' . $conteudo . '%';  // O parâmetro da busca
            $stmt = $db->prepare($sql);
            $stmt->execute($params);  // consulta com os parâmetros

            //posts encontrados
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Usa o método log() para registrar a exceção
            $this->logger->log("Erro ao buscar posts com filtro: " . $e->getMessage());
            return null;
        }
    }

    public function updatePost($post, $newContent)
    {
        $post->setContent($newContent);
        $post->updateInDatabase();
        $this->logger->update($post, 'updated');  // Registra o log de atualização

        return $post;
    }

    public function deletePost($post)
    {
        $post->deleteFromDatabase();
        $this->logger->update($post, 'deleted');  // Registra o log de exclusão

        return $post;
    }

    // Retorna os logs registrados
    public function getLogs()
    {
        return $this->logger->getLogs();
    }
}

