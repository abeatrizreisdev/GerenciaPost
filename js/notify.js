toastr.options = {
    "closeButton": true,  // Exibe o botão de fechar
    "debug": false,
    "newestOnTop": true,  // As notificações mais recentes aparecem em cima
    "progressBar": true,  // Exibe barra de progresso
    "positionClass": "toast-top-right",  // Posição da notificação (canto superior direito)
    "preventDuplicates": true,  // Evita duplicação de notificações
    "onclick": null,
    "showDuration": "300",  // Duração de aparecimento da notificação (em milissegundos)
    "hideDuration": "1000",  // Duração de desaparecimento da notificação (em milissegundos)
    "timeOut": "5000",  // Tempo de exibição da notificação (em milissegundos)
    "extendedTimeOut": "1000"
};

// Exemplo de exibição de notificações
function showNotification(message, type) {
    switch (type) {
        case 'success':
            toastr.success(message);  // Notificação de sucesso
            break;
        case 'info':
            toastr.info(message);  // Notificação de informação
            break;
        case 'warning':
            toastr.warning(message);  // Notificação de alerta
            break;
        case 'error':
            toastr.error(message);  // Notificação de erro
            break;
        default:
            toastr.info(message);  // Caso o tipo não seja identificado, exibe como informação
    }
}

// Teste da notificação
showNotification('Post criado com sucesso!', 'success');
