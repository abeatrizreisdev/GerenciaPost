<?php
date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . "/factory/PostFactory.php";
require_once __DIR__ . "/factory/TextPost.php";
require_once __DIR__ . '/factory/ImagePost.php';
require_once __DIR__ . '/factory/VideoPost.php';
require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . '/facade/PostManager.php'; // Importa o PostManager
require_once __DIR__ . '/observer/PostLogger.php'; // Importa o PostLogger

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

    // Upload de imagem
    if ($tipo === 'image' && isset($imagem['name']) && $imagem['name'] !== '') {
        $imagemUrl = $uploadDir . basename($imagem['name']);
        if (!move_uploaded_file($imagem['tmp_name'], $imagemUrl)) {
            echo "Falha no upload da imagem!";
            exit;
        }
    } else {
        $imagemUrl = null;
    }
    
    if ($tipo === 'video' && isset($video['name']) && $video['name'] !== '') {
        $videoUrl = $uploadDir . basename($video['name']);
        if (!move_uploaded_file($video['tmp_name'], $videoUrl)) {
            echo "Falha no upload do vídeo!";
            exit;
        }
    } else {
        $videoUrl = null;
    }
    

    if (empty($conteudo)) {
        echo "Conteúdo do post não especificado!";
        exit;
    }

    // Criação do post usando o PostManager
    try {
        if ($tipo === 'image' && $imagemUrl) {
            $post = $postManager->createPost($tipo, $conteudo, $imagemUrl, null);  // Passa imagemUrl
        } elseif ($tipo === 'video' && $videoUrl) {
            $post = $postManager->createPost($tipo, $conteudo, null, $videoUrl);  // Passa videoUrl
        } elseif ($tipo === 'text' && $conteudo) {
            $post = $postManager->createPost($tipo, $conteudo, null, null);  // Apenas conteúdo
        }
    
        echo "Post criado e salvo com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao criar o post: " . $e->getMessage();
    }
    
} 

echo "<pre><strong>Logs:</strong>\n" . $postManager->getLogs() . "</pre>";


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
        <textarea name="conteudo" id="conteudo" required></textarea><br>

        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem" id="imagem"><br>

        <label for="video">Vídeo:</label>
        <input type="file" name="video" id="video"><br>

        <input type="submit" value="Criar Post">
    </form>

    <a href="home.php">Voltar para Visualização</a>
</body>

</html>
