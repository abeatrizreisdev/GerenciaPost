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

    $imagemUrl = null;
    $videoUrl = null;
    $uploadDir = '../uploads/';

    // Upload de imagem
    if ($tipo === 'image') {
        if (!empty($_FILES['imagem']['name'])) {
            $imagemUrl = $uploadDir . basename($_FILES['imagem']['name']);
            if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemUrl)) {
                echo "Erro no upload da imagem.";
                exit;
            }
        } else {
            echo "Imagem não fornecida para o post do tipo 'image'.";
            exit;
        }
    }

    // Upload de vídeo
    if ($tipo === 'video') {
        if (!empty($_FILES['video']['name'])) {
            $videoUrl = $uploadDir . basename($_FILES['video']['name']);
            if (!move_uploaded_file($_FILES['video']['tmp_name'], $videoUrl)) {
                echo "Erro no upload do vídeo.";
                exit;
            }
        } else {
            echo "Vídeo não fornecido para o post do tipo 'video'.";
            exit;
        }
    }

    try {
        if ($tipo === 'image') {
            $post = $postManager->createPost('image', $conteudo, $imagemUrl, null);
        } elseif ($tipo === 'video') {
            $post = $postManager->createPost('video', $conteudo, null, $videoUrl);
        } elseif ($tipo === 'text') {
            if (empty($conteudo)) {
                throw new Exception("Conteúdo do post de texto não pode estar vazio.");
            }
            $post = $postManager->createPost('text', $conteudo, null, null);
        } else {
            throw new Exception("Tipo de post inválido.");
        }

        echo "Post criado com sucesso!";
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
    <link rel="stylesheet" href="../css/geral.css">
    <title>Criar Post</title>
</head>

<body>
    <header id="headerMain"></header>
    <br>
    <p class="tituloGeral">Preencha o formulário abaixo:</p>
    <form action="createPost.php" method="POST" enctype="multipart/form-data" class="formCriar">
        <br>
        <div class="tamForm">
            <div class="labeForm">
                <label for="tipo" class="labels">Tipo de Post:</label>
                <select name="tipo" id="tipo" required>
                    <option value="text">Texto</option>
                    <option value="image">Imagem</option>
                    <option value="video">Vídeo</option>
                </select>
            </div>
            <br>
            <div id="divConteudo">
                <label for="conteudo" class="labels">Conteúdo/Texto:</label>
                <textarea name="conteudo" id="conteudo" required></textarea><br>
            </div>
            <div class="labeForm">
                <label for="imagem" class="labels">Imagem:</label>
                <input type="file" name="imagem" id="imagem"><br>
            </div>
            <div class="labeForm">
                <label for="video" class="labels">Vídeo:</label>
                <input type="file" name="video" id="video"><br>
            </div>
        </div>
        <br>
        <br>
        <input type="submit" value="Criar Post" id="btnCriar">

    </form>

    <script src="../js/header.js"></script>

</body>

</html>