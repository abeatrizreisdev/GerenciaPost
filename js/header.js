const header = document.getElementById('headerMain');

// Define o conteúdo HTML do header
header.innerHTML = `
    <h2>Gernciador de Post</h2>
        <div class="barraNav">
            <p><a href="#home">Home</a></p>
            <p><a  href="createPost.php">Criar Post</a></p>
            <p><a href="readPost.php">Procurar Post</a></p>
        </div>`;