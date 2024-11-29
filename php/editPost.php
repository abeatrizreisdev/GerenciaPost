<?php
require_once 'config/conexao.php';
require_once 'factory/PostFactory.php';
require_once 'facade/PostManager.php';
require_once 'observer/PostLogger.php';

// Instanciar gerenciador de posts
$postLogger = new PostLogger();
$postManager = new PostManager($postLogger);

// Variáveis de erro e sucesso
$mensagem = '';
$erro = false;

// Verifica se o ID do post foi passado pela URL
if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Buscar o post usando o PostManager
    $post = $postManager->buscarPostPorId($postId);

    if (!$post) {
        echo "Post não encontrado!";
        exit;
    }

    // Preparar os dados do post para a edição
    $textoPost = htmlspecialchars($post->getTexto());
    // Se o post for do tipo imagem ou vídeo, pegue a URL do arquivo também
    $imagemUrl = $post->getImagemUrl() ?? '';
    $videoUrl = $post->getVideoUrl() ?? '';
} else {
    echo "ID do post não fornecido.";
    exit;
}

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['id'];
    $novoTexto = $_POST['texto'];
    $novaImagemUrl = $_POST['imagem'] ?? null;
    $novoVideoUrl = $_POST['video'] ?? null;

    try {
        // Atualiza o post
        $postManager->editarPost($postId, $novoTexto, $novaImagemUrl, $novoVideoUrl);
        $mensagem = "Post atualizado com sucesso!";
    } catch (Exception $e) {
        $erro = true;
        $mensagem = "Erro ao atualizar post: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Post</title>
</head>
<body>
    <h1>Editar Post</h1>

    <?php if ($mensagem): ?>
        <p style="color: <?php echo $erro ? 'red' : 'green'; ?>"><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <form method="POST" action="editPost.php">
        <input type="hidden" name="id" value="<?php echo $postId; ?>">

        <label for="texto">Texto do Post</label><br>
        <textarea name="texto" id="texto" rows="4" cols="50"><?php echo $textoPost; ?></textarea><br>

        <?php if ($imagemUrl): ?>
            <label for="imagem">Imagem URL</label><br>
            <input type="text" name="imagem" id="imagem" value="<?php echo $imagemUrl; ?>"><br>
        <?php endif; ?>

        <?php if ($videoUrl): ?>
            <label for="video">Vídeo URL</label><br>
            <input type="text" name="video" id="video" value="<?php echo $videoUrl; ?>"><br>
        <?php endif; ?>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
