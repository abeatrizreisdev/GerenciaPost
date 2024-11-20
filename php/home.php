<?php
require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . "/factory/PostFactory.php";
require_once __DIR__ . '/facade/PostManager.php'; // Importa o PostManager
require_once __DIR__ . '/observer/PostLogger.php'; // Importa o PostLogger


// Instancia o logger e o gerenciador de posts
$postLogger = new PostLogger();
$postManager = new PostManager($postLogger);

try {
    $db = Database::getInstance();
    $query = $db->query("SELECT * FROM posts");
    $posts = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erro ao buscar os posts: " . $e->getMessage());
}
echo "<pre><strong>Logs:</strong>\n" . $postManager->getLogs() . "</pre>";

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
                <h3><?php echo htmlspecialchars($post['tipo']); ?></h3>
                <?php if ($post['tipo'] === 'text'): ?>
                    <p><?php echo htmlspecialchars($post['conteudo']); ?></p>
                <?php elseif ($post['tipo'] === 'image'): ?>
                    <img src="../uploads/<?php echo htmlspecialchars($post['conteudo']); ?>" alt="Imagem do Post" style="max-width: 100%;">
                <?php elseif ($post['tipo'] === 'video'): ?>
                    <video controls>
                        <source src="../uploads/<?php echo htmlspecialchars($post['conteudo']); ?>" type="video/mp4">
                        Seu navegador não suporta o vídeo.
                    </video>
                <?php endif; ?>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
