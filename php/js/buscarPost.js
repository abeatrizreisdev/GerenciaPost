document.getElementById('filtroForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Impede o envio do formulário e recarregamento da página

    const busca = document.getElementById('busca').value;
    const filtro = document.getElementById('filtro').value;

    // Requisição para o backend com filtro e busca
    fetch(`index.php?filtro=${filtro}&busca=${encodeURIComponent(busca)}`)
        .then(response => response.json())  // Converte a resposta para JSON
        .then(posts => {
            const container = document.getElementById('postContainer');
            container.innerHTML = ''; // Limpa os posts anteriores

            if (posts.length === 0) {
                container.innerHTML = '<p>Nenhum post encontrado.</p>';
                return;
            }

            // Preenche o container com os posts recebidos
            posts.forEach(post => {
                const postDiv = document.createElement('div');
                postDiv.classList.add('post');

                const tipo = document.createElement('h3');
                tipo.textContent = `Tipo: ${post.tipo ?? 'Desconhecido'}`;
                postDiv.appendChild(tipo);

                if (post.texto) {
                    const texto = document.createElement('p');
                    texto.textContent = `Texto: ${post.texto}`;
                    postDiv.appendChild(texto);
                }

                if (post.imagem_url) {
                    const imagem = document.createElement('img');
                    imagem.src = `../uploads/${post.imagem_url}`;
                    imagem.alt = 'Imagem do Post';
                    imagem.style.maxWidth = '100%';
                    postDiv.appendChild(imagem);
                }

                if (post.video_url) {
                    const video = document.createElement('video');
                    video.controls = true;

                    const source = document.createElement('source');
                    source.src = `../uploads/${post.video_url}`;
                    source.type = 'video/mp4';
                    video.appendChild(source);

                    video.textContent = 'Seu navegador não suporta o vídeo.';
                    postDiv.appendChild(video);
                }

                container.appendChild(postDiv); // Adiciona o post no container
            });
        })
        .catch(error => {
            console.error('Erro ao buscar posts:', error);
        });
});
