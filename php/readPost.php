<?php
require_once 'config/conexao.php';
require_once 'facade/PostManager.php';
require_once 'observer/PostLogger.php';

$postManager = new PostManager(new PostLogger());

// Verifica se é uma requisição AJAX
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['filtro'])) {
    $filtro = $_GET['filtro'] ?? 'all';
    $busca = $_GET['busca'] ?? '';
    $posts = $postManager->buscarPostsPorFiltro($filtro, $busca);

    // Retorna os dados em formato JSON
    header('Content-Type: application/json');
    echo json_encode($posts);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .post {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .filtro-container {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h1>Procurar Posts</h1>

    <div class="filtro-container">
        <form id="filtroForm">
            <input type="text" id="busca" placeholder="Buscar conteúdo...">
            <select id="filtro">
                <option value="all">Todos</option>
                <option value="image">Imagens</option>
                <option value="text">Textos</option>
                <option value="video">Vídeos</option>
            </select>
            <button type="submit">Filtrar</button>
        </form>
    </div>

    <div id="postContainer">
        <!-- Os posts serão mostrados aqui -->
    </div>
    <script src="/../js/buscarPost.js"></script>
</body>