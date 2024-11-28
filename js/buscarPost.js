document.getElementById('searchButton').addEventListener('click', function () {
    const searchTerm = document.getElementById('search').value;
    const filter = document.getElementById('filter').value;

    // Enviar a requisição AJAX para o PHP
    fetch('readPost.php', {  // Altere para o arquivo correto, como 'readPost.php'
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            filter: filter,
            search: searchTerm,
        }),
    })
        .then(response => response.text())
        .then(html => {
            // Atualizar o conteúdo do contêiner com os posts
            document.getElementById('postsContainer').innerHTML = html;
        })
        .catch(error => console.error('Erro ao buscar os posts:', error));
});