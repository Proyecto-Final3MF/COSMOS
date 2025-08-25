document.addEventListener('DOMContentLoaded', function() {
    const toggleTemaBtn = document.getElementById('toggleTemaBtn');
    const bodyElement = document.body; // 'document.body' já se refere diretamente ao elemento body

    toggleTemaBtn.addEventListener('click', function() {
        // Alterna entre as classes 'tema-claro' e 'tema-escuro' no body
        bodyElement.classList.toggle('tema-claro');
        bodyElement.classList.toggle('tema-escuro');

        // Opcional: Salvar a preferência do usuário (ex: no LocalStorage)
        // Isso faria com que o tema escolhido persistisse mesmo se o usuário sair da página e voltar
        if (bodyElement.classList.contains('tema-escuro')) {
            localStorage.setItem('tema', 'escuro');
        } else {
            localStorage.setItem('tema', 'claro');
        }
    });

    // Opcional: Carregar a preferência de tema ao carregar a página
    const savedTheme = localStorage.getItem('tema');
    if (savedTheme === 'escuro') {
        bodyElement.classList.remove('tema-claro');
        bodyElement.classList.add('tema-escuro');
    } else {
        bodyElement.classList.remove('tema-escuro');
        bodyElement.classList.add('tema-claro');
    }
});