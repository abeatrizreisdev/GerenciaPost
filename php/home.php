<?php
require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . "/factory/PostFactory.php";
require_once __DIR__ . '/facade/PostManager.php'; // Importa o PostManager
require_once __DIR__ . '/observer/PostLogger.php'; // Importa o PostLogger

// Instancia o logger e o gerenciador de posts
$postLogger = new PostLogger();
$postManager = new PostManager($postLogger); // Passe o logger para o PostManager

try {
    $db = Database::getInstance();
    $query = $db->query("SELECT * FROM posts");
    $posts = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erro ao buscar os posts: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de Posts</title>
</head>

<body>
    <h1>Visualizar Posts</h1>
    <a href="createPost.php">Criar Novo Post</a>
    <hr>

    <?php if (empty($posts)): ?>
        <p>Não há posts disponíveis.</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <div>
                <h3>Tipo: <?php echo htmlspecialchars($post['tipo']); ?></h3>

                <?php if ($post['tipo'] === 'text' && !empty($post['texto'])): ?>
                    <p>Texto: <?php echo htmlspecialchars($post['texto']); ?></p>

                <?php elseif ($post['tipo'] === 'image' && !empty($post['imagem_url'])): ?>
                    <img src="../uploads/<?php echo htmlspecialchars($post['imagem_url']); ?>" alt="Imagem do Post"
                        style="max-width: 100%;">

                <?php elseif ($post['tipo'] === 'video' && !empty($post['video_url'])): ?>
                    <video controls>
                        <source src="../uploads/<?php echo htmlspecialchars($post['video_url']); ?>" type="video/mp4">
                        Seu navegador não suporta o vídeo.
                    </video>
                <?php else: ?>
                    <p>Conteúdo não disponível ou tipo de post desconhecido.</p>
                <?php endif; ?>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>