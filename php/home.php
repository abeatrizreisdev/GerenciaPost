<?php
require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . "/factory/PostFactory.php";
require_once __DIR__ . '/observer/PostLogger.php'; // Importa o PostLogger
require_once __DIR__ . '/facade/PostManager.php'; // Importa o PostLogger

// Instancia o logger
$postLogger = new PostLogger();
$postManager = new PostManager($postLogger);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="../css/geral.css">
    <title>Visualização de Posts</title>
</head>

<body>
    <header id="headerMain"></header>
    <hr>
    <div class="containerPost">
        <?php
        require_once __DIR__ . '/config/conexao.php';
        require_once __DIR__ . "/factory/PostFactory.php";
        require_once __DIR__ . '/observer/PostLogger.php'; // Importa o PostLogger
        

        $html = '<div class="ajustarMeio">';
        $html = '<br>';

        try {
            $db = Database::getInstance();
            $query = $db->query("SELECT * FROM posts");
            $posts = $query->fetchAll(PDO::FETCH_ASSOC);


            $html .= ''; 
        

            foreach ($posts as $postData) {
                switch ($postData['tipo']) {
                    case 'image':
                        $post = new ImagePost($postData['id'], $postData['texto'], $postData['imagem_url'], new ImagePostStrategy());
                        break;

                    case 'video':
                        $post = new VideoPost($postData['video_url'], $postData['texto'], $postData['id'], new VideoPostStrategy());
                        break;

                    case 'text':
                        $post = new TextPost($postData['texto'], $postData['id'], new TextPostStrategy());
                        break;

                    default:
                        throw new Exception("Tipo de post desconhecido.");
                }

                if ($postData['tipo'] === 'image') {
                    $html .= '<div class="postImagem">';
                } elseif ($postData['tipo'] === 'video') {
                    $html .= '<div class="postVideo">';
                } else {
                    $html .= '<div class="postTexto">';
                }
    
                $html .= $post->display();
                $html .= "</div>";
            }

            echo $html;

        } catch (Exception $e) {
            die("Erro ao buscar os posts: " . $e->getMessage());
        }
        ?>
    </div>

    <script src="../js/header.js"></script>

</body>

</html>