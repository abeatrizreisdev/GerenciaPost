document.addEventListener('DOMContentLoaded', function() {
    // Manipula o botão de exclusão
    document.querySelectorAll('.deletePost').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id'); // Obtém o ID do post
            if (confirm('Tem certeza que deseja excluir este post?')) {
                // Envia a requisição para excluir o post
                fetch('/../php/readPost.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + postId // Passa o ID do post para o PHP
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remover o post da lista sem recarregar a página
                        const postElement = document.querySelector(`.post[data-post-id="${postId}"]`);
                        if (postElement) {
                            postElement.remove(); // Remove o post da DOM
                        }
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
            }
        });
    });
});
