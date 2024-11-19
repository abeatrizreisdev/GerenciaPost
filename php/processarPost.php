<?php
require_once ('./classes/factory/PostFactory.php');
require_once ('./classes/factory/TextPost.php');
require_once ('./classes/factory/ImagePost.php');
require_once ('./classes/factory/VideoPost.php');
require_once ('./classes/database/conexao.php');
require_once ('./classes/facade/PostManager.php'); // Adicione o require do PostManager


// Verificar se o formulário foi enviado
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

    // Criação e salvamento do post
    try {
        $post = PostFactory::createPost($tipo, $conteudo, $imagemUrl, $videoUrl);

        // Salvar no banco de dados
        $post->saveToDatabase();

        echo "Post criado e salvo com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao criar o post: " . $e->getMessage();
    }
} else {
    echo "Método inválido. Por favor, envie o formulário corretamente.";
}
?>
