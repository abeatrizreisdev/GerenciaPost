<?php
require_once __DIR__ . "/../factory/PostFactory.php";
require_once __DIR__ . "/../observer/PostLogger.php";


class PostManager
{
    private $logger;

    // Agora o construtor recebe um logger como parâmetro
    public function __construct(PostLogger $logger) {
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

    public function buscarPostPorId($postId)
    {
        // Conectar ao banco de dados (supondo que você tenha uma classe de conexão)
        $db = Database::getInstance();

        // Consultar o banco de dados
        $query = "SELECT * FROM posts WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $postId);
        $stmt->execute();

        // Recuperar o post do banco de dados
        $postData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar se o post foi encontrado
        if ($postData) {
            // Criar a instância do post com base no tipo
            return PostFactory::createPost(
                $postData['tipo'],
                $postData['id'],
                $postData['texto'],
                $postData['imagem_url'] ?? null,
                $postData['video_url'] ?? null
            );
        }

        return null;
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
                    // Buscar todos os campos das 3 tabelas (textPost, imagePost, videoPost)
                    $sql = "SELECT id, texto, tipo, imagem_url, video_url FROM posts WHERE texto LIKE :conteudo";
                    break;
                case 'image':
                    // Consultar apenas os campos da tabela imagePost
                    $sql = "SELECT id, texto, 'image' AS tipo, imagem_url FROM imagePost WHERE texto LIKE :conteudo";
                    break;
                case 'text':
                    // Consultar apenas os campos da tabela textPost
                    $sql = "SELECT id, texto, 'text' AS tipo FROM textPost WHERE texto LIKE :conteudo";
                    break;
                case 'video':
                    // Consultar apenas os campos da tabela videoPost
                    $sql = "SELECT id, texto, 'video' AS tipo, video_url FROM videoPost WHERE texto LIKE :conteudo";
                    break;
                default:
                    throw new Exception("Tipo de filtro inválido: $tipo");
            }

            // Parâmetro de busca com o conteúdo
            $params[':conteudo'] = '%' . $conteudo . '%';  // Parâmetro de busca no texto

            // Preparar e executar a consulta
            $stmt = $db->prepare($sql);
            $stmt->execute($params);

            // Resultados encontrados
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Retorna os resultados ou um array vazio caso não haja resultados
            return $resultados ? $resultados : [];

        } catch (PDOException $e) {
            // Registra a exceção no log
            $this->logger->log("Erro ao buscar posts com filtro: " . $e->getMessage());
            return null;
        }
    }


    public function editarPost($postId, $dados)
    {
        // Buscar o post pelo ID
        $post = $this->buscarPostPorId($postId);

        if (!$post) {
            throw new Exception("Post com ID $postId não encontrado.");
        }

        // Delegar a atualização com base no tipo
        switch (get_class($post)) {
            case 'TextPost':
                $post->editarPost($dados['texto'], $dados['video'], $dados['imagem']);
                break;
            case 'ImagePost':
                $post->editarPost($dados['texto'], $dados['video'], $dados['imagem']);
                break;
            case 'VideoPost':
                $post->editarPost($dados['texto'], $dados['video'], $dados['imagem']);
                break;
            default:
                throw new Exception("Tipo de post desconhecido.");
        }

        // Registrar log de atualização
        $this->logger->update($post, 'updated');

    }




    public function deletePost($post)
    {
        $post->deleteFromDatabase();
        $this->logger->update($post, 'deleted');  // Registra o log de exclusão

        return $post;
    }

    // Retorna os logs registrados
    public function getLogs() {
        return $this->logger->getLogs();
    }
}

