<?php
require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . "/factory/PostFactory.php";
require_once __DIR__ . '/observer/PostLogger.php'; // Importa o PostLogger

// Instancia o logger
$postLogger = new PostLogger();
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
        
        // Instancia o logger
        $postLogger = new PostLogger();

        // Variável para armazenar o conteúdo HTML dos posts
        $html = '<div class="ajustarMeio">';
        $html = '<br>';

        try {
            // Conexão com o banco de dados e busca de todos os posts
            $db = Database::getInstance();
            $query = $db->query("SELECT * FROM posts");
            $posts = $query->fetchAll(PDO::FETCH_ASSOC);

            // Começa a criar o HTML para o containerPost logo após o header
            $html .= ''; // Inicia a div containerPost
        
            // Itera sobre cada post para gerar o HTML correspondente
            foreach ($posts as $postData) {
                // Instanciar o Post de acordo com o tipo
                switch ($postData['tipo']) {
                    case 'image':
                        // Instanciando a classe específica para posts de imagem
                        $post = new ImagePost($postData['id'], $postData['texto'], $postData['imagem_url'], new ImagePostStrategy());
                        break;

                    case 'video':
                        // Instanciando a classe específica para posts de vídeo
                        $post = new VideoPost($postData['video_url'], $postData['texto'], $postData['id'], new VideoPostStrategy());
                        break;

                    case 'text':
                        // Instanciando a classe específica para posts de texto
                        $post = new TextPost($postData['texto'], $postData['id'], new TextPostStrategy());
                        break;

                    default:
                        // Caso o tipo de post seja desconhecido
                        throw new Exception("Tipo de post desconhecido.");
                }

                // Começa a criar o HTML para o post
                if ($postData['tipo'] === 'image') {
                    $html .= '<div class="postImagem">';
                } elseif ($postData['tipo'] === 'video') {
                    $html .= '<div class="postVideo">';
                } else {
                    $html .= '<div class="postTexto">';
                }
    
                // Conteúdo principal do post
                $html .= $post->display();
                $html .= "</div>";
            }

            // Exibe o conteúdo HTML gerado para todos os posts dentro de containerPost
            echo $html;

        } catch (Exception $e) {
            die("Erro ao buscar os posts: " . $e->getMessage());
        }
        ?>
    </div>

    <script src="../js/header.js"></script>
</body>

</html>