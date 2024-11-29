document.addEventListener('DOMContentLoaded', function() {
    // Função que exibe o pop-up para confirmar a exclusão do post
    function popUpDeletarPost(postId) {
        const confirmDelete = confirm("Tem certeza que deseja excluir este post?");
        if (confirmDelete) {
            // Enviar requisição para excluir o post
            fetch(`/deletar-post.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: postId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Post excluído com sucesso!');
                    location.reload();  // Atualiza a página
                } else {
                    alert('Erro ao excluir o post.');
                }
            });
        }
    }

    // Adicionar evento de clique no link de exclusão
    document.querySelectorAll('.deletePost').forEach(button => {
        button.addEventListener('click', function() {
            const postId = button.getAttribute('data-post-id');
            popUpDeletarPost(postId);  // Chama a função popUpDeletarPost passando o ID do post
        });
    });
});
