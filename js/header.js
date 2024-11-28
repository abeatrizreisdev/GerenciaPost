const header = document.getElementById('headerMain');

// Define o conteúdo HTML do header
header.innerHTML = `
    <p class="titulo">GERENCIADOR DE POSTS</p>
        <div class="barraNav">
            <p class="btnNav"><a href="home.php">Home</a></p>
            <p class="btnNav"><a  href="createPost.php">Criar Post</a></p>
            <p class="btnNav"><a href="readPost.php">Procurar/Editar Posts</a></p>
        </div>`;