<?php

require_once('../classes/facade/PostManager.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $content = $_POST['content'];

    try {
        $postManager = new PostManager();
        $post = $postManager->createPost($type, $content);

        echo $post->display();
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<!-- Formulário HTML -->
<form action="processarPost.php" method="POST" enctype="multipart/form-data">
    <label for="tipo">Tipo de Post:</label>
    <select name="tipo" id="tipo" required>
        <option value="text">Texto</option>
        <option value="image">Imagem</option>
        <option value="video">Vídeo</option>
    </select><br>

    <label for="conteudo">Conteúdo (para texto):</label>
    <textarea name="conteudo" id="conteudo"></textarea><br>

    <label for="imagem">Imagem (se for imagem):</label>
    <input type="file" name="imagem" id="imagem"><br>

    <label for="video">Vídeo (se for vídeo):</label>
    <input type="file" name="video" id="video"><br>

    <input type="submit" value="Salvar Post">
</form>



