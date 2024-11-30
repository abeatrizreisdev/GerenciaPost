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

        // Registro no logger
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

    public function buscarPostsPorFiltro($tipo, $conteudo = '', $id, $texto, $imagemUrl, $videoUrl, $strategy)
    {
        try {
            $db = Database::getInstance();
            $sql = "";
            $params = [];
            switch ($tipo) {
                case 'all':
                    // Buscar todos os campos das 3 tabelas (textPost, imagePost, videoPost)
                    $sql = "SELECT id, texto, tipo, imagem_url, video_url FROM posts WHERE texto LIKE :conteudo";
                    break;
                case 'TextPost':
                    $post = new TextPost($texto, $id, $strategy);
                    $posts = $post->readPost($conteudo);  // Chama o método da classe TextPost
                    return $posts;
                case 'image':
                    $post = new ImagePost($id, $texto, $imagemUrl, $strategy);
                    $posts = $post->readPost($conteudo);  // Chama o método da classe ImagePost
                    return $posts;  // Retorna os posts encontrados
                case 'video':
                    $post = new VideoPost($videoUrl, $texto, $id, $strategy);
                    $posts = $post->readPost($conteudo);  // Chama o método da classe VideoPost
                    return $posts;
                default:
                    throw new Exception("Tipo de post desconhecido.");
            }

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
        $this->logger->update($post, 'updated'); // Registra a atualização
    }



    public function deletePost($postId)
    {
        // Buscar o post no banco de dados antes de excluir
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->bindParam(':id', $postId);
        $stmt->execute();
        $postData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$postData) {
            throw new Exception("Post não encontrado.");
        }

        // Instancia o post de acordo com os dados do banco
        switch ($postData['tipo']) {
            case 'image':
                $post = new ImagePost($postData['id'], $postData['texto'], $postData['imagem_url'], $postData['strategy']);
                break;
            case 'video':
                $post = new VideoPost($postData['id'], $postData['texto'], $postData['video_url'], $postData['strategy']);
                break;
            case 'text':
                $post = new TextPost($postData['id'], $postData['texto'], $postData['strategy']);
                break;
            default:
                throw new Exception("Tipo de post desconhecido.");
        }

        // Chama o método delete da classe de post
        $post->deletePost(); // Isso irá excluir o post e registrar o log
        $this->logger->update($post, 'deleted'); // Registra a exclusão do post

    }
    // Retorna os logs registrados
    public function getLogs()
    {
        return $this->logger->getLogs();
    }
}

