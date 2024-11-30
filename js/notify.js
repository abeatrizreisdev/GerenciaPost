toastr.options = {
    "closeButton": true,  // Exibe o botão de fechar
    "debug": false,
    "newestOnTop": true,  // As notificações mais recentes aparecem em cima
    "progressBar": true,  // Exibe a barra de progresso
    "positionClass": "toast-top-right",  // Posição da notificação (canto superior direito)
    "preventDuplicates": true,  // Evita duplicação de notificações
    "onclick": null,
    "showDuration": "300",  // Duração de aparecimento da notificação (em milissegundos)
    "hideDuration": "1000",  // Duração de desaparecimento da notificação (em milissegundos)
    "timeOut": "5000",  // Tempo de exibição da notificação (em milissegundos)
    "extendedTimeOut": "1000"
};

// Função para exibir uma notificação personalizada
function showNotification(type) {
    switch (type) {
        case 'created':
            toastr.success("Post Criado Com Sucesso");  // Notificação de sucesso
            break;
        case 'updated':
            toastr.info("Post Atualizado com Sucesso");  // Notificação de informação
            break;
        case 'deleted':
            toastr.warning("Post Apagado com Sucesso");  // Notificação de alerta
            break;
        default:
            toastr.info("Não identificado");  // Caso o tipo não seja identificado, exibe como informação
            break;
    }
}

// Teste da notificação (exemplo de criação de post)
