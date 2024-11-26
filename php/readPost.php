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
        $html = '';
        foreach ($posts as $postData) {
            // Verifique se o tipo de post é válido antes de criar o post
            $post = PostFactory::createPost(
                $postData['tipo'],
                $postData['texto'] ?? $postData['imagemUrl'] ?? $postData['videoUrl'],
                $postData['imagemUrl'] ?? null,
                $postData['videoUrl'] ?? null
            );
            if (!$post->getStrategy()) {
                echo "Estratégia não definida para o post ID: " . $post->getId();
                continue; // Pule este post
            }
            // Usar a estratégia para exibir o post
            $html .= '<div class="post">';
            $html .= $post->display();  // Exibe o conteúdo completo gerado pela estratégia
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
    <title>Posts Dinâmicos</title>
    <style>
        .post {
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 10px;
        }
    </style>
</head>

<body>
    <h1>Posts</h1>

    <div>
        <input type="text" id="search" placeholder="Buscar posts">
        <select id="filter">
            <option value="all">Todos</option>
            <option value="text">Texto</option>
            <option value="image">Imagem</option>
            <option value="video">Vídeo</option>
        </select>
        <button id="searchButton">Buscar</button>
    </div>

    <div id="postsContainer">
        <!-- Os posts serão carregados aqui -->
    </div>

    <script>
        document.getElementById('searchButton').addEventListener('click', function () {
            const searchTerm = document.getElementById('search').value;
            const filter = document.getElementById('filter').value;

            // Enviar a requisição AJAX para o PHP
            fetch('readPost.php', {  // Altere para o arquivo correto, como 'readPost.php'
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    filter: filter,
                    search: searchTerm,
                }),
            })
                .then(response => response.text())
                .then(html => {
                    // Atualizar o conteúdo do contêiner com os posts
                    document.getElementById('postsContainer').innerHTML = html;
                })
                .catch(error => console.error('Erro ao buscar os posts:', error));
        });

    </script>
</body>

</html>