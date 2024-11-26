document.getElementById('filtroForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const busca = document.getElementById('busca').value;
    const filtro = document.getElementById('filtro').value;

    fetch(`buscarPosts.php?filtro=${filtro}&busca=${encodeURIComponent(busca)}`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('postContainer');
            container.innerHTML = '';

            if (data.error) {
                container.innerHTML = `<p>${data.error}</p>`;
                return;
            }

            if (data.length === 0) {
                container.innerHTML = '<p>Nenhum post encontrado.</p>';
                return;
            }

            data.forEach(html => {
                const postDiv = document.createElement('div');
                postDiv.innerHTML = html;
                container.appendChild(postDiv);
            });
        })
        .catch(error => {
            console.error('Erro:', error);
        });
});
