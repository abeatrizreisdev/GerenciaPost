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

function showNotification(message, event) {
    switch (event) {
        case 'created':
            toastr.success(message, "Post Criado");
            break;
        case 'updated':
            toastr.info(message, "Post Atualizado");
            break;
        case 'deleted':
            toastr.warning(message, "Post Excluído");
            break;
        default:
            toastr.error("Evento desconhecido", "Erro");
    }
}
