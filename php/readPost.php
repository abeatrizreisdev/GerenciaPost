<?php
// Incluindo as classes necessárias
require_once __DIR__ .'/config/conexao.php';  // Inclua o caminho correto para o PostFactory
require_once __DIR__ .'/factory/PostFactory.php';  // Inclua o caminho correto para o PostFactory
require_once __DIR__ .'/facade/PostManager.php';  // Inclua o caminho correto para o PostManager
require_once __DIR__ .'/observer/PostLogger.php';   // Inclua o caminho correto para o PostLogger


// Criando uma instância do PostManager
$postLogger = new PostLogger();
$postManager = new PostManager($postLogger);

// Variáveis de busca
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$searchType = isset($_GET['tipo']) ? $_GET['tipo'] : '';

// Buscando posts com o novo nome da função
$posts = $postManager->readPost($searchTerm, $searchType);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        h2 {
            color: #333;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .search-form input,
        .search-form select {
            padding: 10px;
            font-size: 16px;
            margin-right: 10px;
        }
        .search-form button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        .search-form button:hover {
            background-color: #0056b3;
        }
        .post {
            background-color: #fff;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
        }
        .post h3 {
            margin-top: 0;
            color: #007BFF;
        }
        .post img {
            max-width: 100%;
            border-radius: 8px;
        }
        .post video {
            max-width: 100%;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Pesquisar Posts</h2>
    <form action="" method="GET" class="search-form">
        <label for="search">Buscar conteúdo:</label>
        <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Digite o conteúdo para buscar...">
        <label for="tipo">Tipo de post:</label>
        <select name="tipo" id="tipo">
            <option value="">Todos</option>
            <option value="text" <?php echo ($searchType === 'text' ? 'selected' : ''); ?>>Texto</option>
            <option value="image" <?php echo ($searchType === 'image' ? 'selected' : ''); ?>>Imagem</option>
            <option value="video" <?php echo ($searchType === 'video' ? 'selected' : ''); ?>>Vídeo</option>
        </select>
        <button type="submit">Buscar</button>
    </form>

    <h2>Resultados da Pesquisa</h2>

    <?php if (count($posts) > 0): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <h3>Tipo: <?php echo ucfirst($post->getTipo()); ?></h3> <!-- Usando o método getTipo() -->
                <p><strong>Conteúdo:</strong> <?php echo $post->getConteudo(); ?></p>

                <?php if ($post instanceof ImagePost): ?>
                    <p><strong>Imagem:</strong> <img src="<?php echo $post->getImagemUrl(); ?>" alt="Imagem do post"></p>
                <?php elseif ($post instanceof VideoPost): ?>
                    <p><strong>Vídeo:</strong> <video controls>
                        <source src="<?php echo $post->getVideoUrl(); ?>" type="video/mp4">
                        Seu navegador não suporta o elemento de vídeo.
                    </video></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum post encontrado.</p>
    <?php endif; ?>

</div>

</body>
</html>

