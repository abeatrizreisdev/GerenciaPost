<?php
// Incluir os arquivos necessários
require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . '/factory/TextPost.php';
require_once __DIR__ . '/factory/ImagePost.php';
require_once __DIR__ . '/factory/VideoPost.php';
require_once __DIR__ . '/facade/PostManager.php'; // A classe que gerencia as atualizações

$postLogger = new PostLogger();
$postManager = new PostManager($postLogger);
// Verificar se o ID do post foi passado na URL
if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Obter a conexão com o banco de dados usando Singleton
    $db = Database::getInstance();

    // Consultar o post no banco de dados para carregar os dados
    $query = "SELECT texto, imagem_url, video_url, tipo FROM posts WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
    $stmt->execute();

    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se o post foi encontrado
    if (!$post) {
        echo "Post não encontrado.";
        exit;
    }

    // Inicializar as variáveis com os valores existentes
    $texto = $post['texto'];
    $imagemUrl = $post['imagem_url'];
    $videoUrl = $post['video_url'];
    $tipoPost = $post['tipo']; // Tipo do post (TextPost, ImagePost, VideoPost)
} else {
    echo "ID do post não fornecido.";
    exit;
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter os dados do formulário
    $texto = $_POST['texto'];
    $videoUrl = isset($_FILES['video_url']) && $_FILES['video_url']['error'] == 0 ? 'uploads/' . $_FILES['video_url']['name'] : $videoUrl;
    $imagemUrl = isset($_FILES['imagem_url']) && $_FILES['imagem_url']['error'] == 0 ? 'uploads/' . $_FILES['imagem_url']['name'] : $imagemUrl;

    // Fazer upload dos arquivos se forem enviados
    if (isset($_FILES['imagem_url']) && $_FILES['imagem_url']['error'] == 0) {
        move_uploaded_file($_FILES['imagem_url']['tmp_name'], $imagemUrl);
    }

    if (isset($_FILES['video_url']) && $_FILES['video_url']['error'] == 0) {
        move_uploaded_file($_FILES['video_url']['tmp_name'], $videoUrl);
    }

    // Preparar os dados para o PostManager
    $dados = [
        'texto' => $texto,
        'video' => $videoUrl,
        'imagem' => $imagemUrl
    ];

    // Instanciar o PostManager e delegar a atualização
    try {
        // Atualizar o post de acordo com seu tipo
        $postManager->editarPost($postId, $dados);

        // Redirecionar para home.php
        header("Location: home.php"); // Redireciona para a página home.php
        exit; // Certifique-se de que o script não continua após o redirecionamento
    } catch (Exception $e) {
        // Em caso de erro, exibe a mensagem de erro
        echo "Erro: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/geral.css">
    <title>Editar Post</title>
</head>

<body>
    <header id="headerMain"></header>
    <br>
    <p class="tituloGeral">Editar Post</p>
    <form action="editPost.php?id=<?php echo $postId; ?>" method="POST" enctype="multipart/form-data">
        <div class="tamaForm">
            <div id="divConteudo">
                <label for="texto" class="labels">Texto:</label>
                <textarea id="conteudo" name="texto" rows="4"
                    cols="50"><?php echo htmlspecialchars($texto); ?></textarea>
            </div>
            <br>
            <div class="labeForm">
                <label for="imagem_url" class="labels">Imagem (opcional):</label>
                <input type="file" id="imagem_url" name="imagem_url">
            </div>
            <br>
            <div class="labeForm">
                <label for="video_url" class="labels">Vídeo (opcional):</label>
                <input type="file" id="video_url" name="video_url">
            </div>

            <br>
            <br>
            <button type="submit" id="btnCriar">Atualizar Post</button>
        </div>
    </form>

    <script src="../js/header.js"></script>

</body>

</html>