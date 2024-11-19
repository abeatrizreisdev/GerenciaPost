<?php

require_once __DIR__ . "./PostFactory.php";
require_once __DIR__ . "./TextPost.php";
require_once __DIR__ . ('./ImagePost.php');
require_once __DIR__ . ('./VideoPost.php');
require_once __DIR__ . ('./conexao.php');
require_once __DIR__ . ('./PostManager.php'); // Importa o PostManager
require_once __DIR__ . ('./PostLogger.php'); // Importa o PostLogger

// Instancia o logger e o gerenciador de posts
$postLogger = new PostLogger();
$postManager = new PostManager($postLogger);

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? null;
    $conteudo = $_POST['conteudo'] ?? null;
    $imagem = $_FILES['imagem'] ?? null;
    $video = $_FILES['video'] ?? null;

    if (!$tipo) {
        echo "Tipo de post não especificado!";
        exit;
    }

    $uploadDir = '../uploads/';
    $imagemUrl = null;
    $videoUrl = null;

    // Upload de imagem
    if ($tipo === 'image' && $imagem) {
        $imagemUrl = $uploadDir . basename($imagem['name']);
        if (!move_uploaded_file($imagem['tmp_name'], $imagemUrl)) {
            echo "Falha no upload da imagem!";
            exit;
        }
    }

    // Upload de vídeo
    if ($tipo === 'video' && $video) {
        $videoUrl = $uploadDir . basename($video['name']);
        if (!move_uploaded_file($video['tmp_name'], $videoUrl)) {
            echo "Falha no upload do vídeo!";
            exit;
        }
    }

    // Criação do post usando o PostFactory
    try {
        // Se for imagem ou vídeo, passamos a URL do arquivo
        if ($tipo === 'image') {
            $post = PostFactory::createPost($tipo, null, $imagemUrl, null);
        } elseif ($tipo === 'video') {
            $post = PostFactory::createPost($tipo, null, null, $videoUrl);
        } else {
            $post = PostFactory::createPost($tipo, $conteudo, null, null);
        }

        // Salva o post no banco de dados
        $post->saveToDatabase();

        echo "Post criado e salvo com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao criar o post: " . $e->getMessage();
    }
} else {
    echo "Método inválido. Por favor, envie o formulário corretamente.";
}

echo "<pre><strong>Logs:</strong>\n" . $postManager->getLogs() . "</pre>"; // Agora $postManager está instanciado
?>

<!-- Formulário HTML -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Post</title>
</head>
<body>
    <h1>Criar Post</h1>
    <form action="createPost.php" method="POST" enctype="multipart/form-data">
        <label for="tipo">Tipo de Post:</label>
        <select name="tipo" id="tipo" required>
            <option value="text">Texto</option>
            <option value="image">Imagem</option>
            <option value="video">Vídeo</option>
        </select><br>

        <label for="conteudo">Conteúdo (apenas texto):</label>
        <textarea name="conteudo" id="conteudo"></textarea><br>

        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem" id="imagem"><br>

        <label for="video">Vídeo:</label>
        <input type="file" name="video" id="video"><br>

        <input type="submit" value="Criar Post">
    </form>

    <a href="index.php">Voltar para Visualização</a>
</body>
</html>
