<?php

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

    } catch (Exception $e) {
        echo "Erro ao criar o post: " . $e->getMessage();
    }

}
echo "<pre><strong>Logs:</strong>\n" . $postManager->getLogs() . "</pre>";
?>

<!-- Formulário HTML -->
<!DOCTYPE html>
<html lang="pt-BR">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/geral.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
    <script src="../js/notify.js"></script>
    <script>toastr.options = {
            "closeButton": true,  // Exibe o botão de fechar
            "debug": false,
            "newestOnTop": true,  // As notificações mais recentes aparecem em cima
            "progressBar": true,  // Exibe a barra de progresso
            "positionClass": "toast-top-right",  // Posição da notificação
            "preventDuplicates": true,  // Evita duplicação de notificações
            "showDuration": "300",  // Duração de aparecimento da notificação (em milissegundos)
            "hideDuration": "1000",  // Duração de desaparecimento da notificação (em milissegundos)
            "timeOut": "5000",  // Tempo de exibição da notificação (em milissegundos)
            "extendedTimeOut": "1000"
        };

        // Teste da notificação
        function showNotification(type) {
            switch (type) {
                case 'created':
                    toastr.success("Post Criado Com Sucesso");  // Notificação de sucesso
                    break;
                case 'updated':
                    toastr.info("Post Atualizado com Sucesso");  // Notificação de informação
                    break;
                case 'deleted':
                    toastr.warning("Post Apagado com Sucesso");  // Notificação de alerta
                    break;
                default:
                    toastr.info("Não identificado");  // Caso o tipo não seja identificado, exibe como informação
                    break;
            }
        }

        // Chama a função para mostrar a notificação
        showNotification('created');  // Teste de criação
    </script>
</body>

</html>