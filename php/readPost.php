<?php
require_once 'config/conexao.php';
require_once 'factory/PostFactory.php';
require_once 'facade/PostManager.php';
require_once 'observer/PostLogger.php';

// Instanciar gerenciador de posts
$postLogger = new PostLogger();
$postManager = new PostManager($postLogger);

// Processar a requisição de busca via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter'])) {
    $filter = $_POST['filter']; // Pode ser 'all', 'text', 'image', ou 'video'
    $searchTerm = $_POST['search'] ?? '';

    // Busca os posts com base no filtro
    $posts = $postManager->buscarPostsPorFiltro($filter, $searchTerm);

    // Verifique se encontrou posts
    if ($posts) {
        $html = '<div class="ajustarMeio">';
        foreach ($posts as $postData) {
            // Verifique se o tipo de post é válido antes de criar o post
            $post = PostFactory::createPost(
                $postData['tipo'],
                $postData['id'],
                $postData['texto'],
                $postData['imagem_url'] ?? null,
                $postData['video_url'] ?? null
            );
            if (!$post->getStrategy()) {
                echo "Estratégia não definida para o post ID: " . $post->getId();
                continue; // Pule este post
            }

            $postId = htmlspecialchars($postData['id']);

            // Crie a estrutura do post com botões
            if ($postData['tipo'] === 'image') {
                $html .= '<div class="postImagem">';
            } elseif ($postData['tipo'] === 'video') {
                $html .= '<div class="postVideo">';
            } else {
                $html .= '<div class="postTexto">';
            }

            // Conteúdo principal do post
            $html .= $post->display();

            // Botões de ação
            $html .= '<div class="postButtons">';
            $html .= '<button class="editPost" data-post-id="' . $postId . '">Editar</button>';
            $html .= '<button class="deletePost" <a href="javascript:void(0)"  data-post-id="' . $postId . '">Excluir</a></button>';
            $html .= '</div>';

            // Fechar a div do post
            $html .= '</div>';
        }

        // Retorna o HTML gerado
        echo $html;
    } else {
        echo '<p>Nenhum post encontrado.</p>';
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/geral.css">
    <title>Procurar Posts</title>
</head>

<body>
    <header id="headerMain"></header>
    <br>
    <br>
    <div class="search">
        <input type="text" id="search" placeholder="Buscar posts">
        <select id="filter">
            <option value="all">Todos</option>
            <option value="text">Texto</option>
            <option value="image">Imagem</option>
            <option value="video">Vídeo</option>
        </select>
        <button id="searchButton">Buscar</button>
    </div>
    <br>
    <div id="postsContainer">
        <!-- Os posts serão carregados aqui -->
    </div>

    <script src="../js/buscarPost.js"></script>
    <script src="../js/header.js"></script>
    <script src="../js/btnEditarPost.js"></script>

</body>

</html>