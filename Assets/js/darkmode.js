document.addEventListener('DOMContentLoaded', function() {
    const toggleTemaBtn = document.getElementById('toggleTemaBtn');
    const bodyElement = document.body;

    toggleTemaBtn.addEventListener('click', function() {
        bodyElement.classList.toggle('tema-claro');
        bodyElement.classList.toggle('tema-escuro');
        if (bodyElement.classList.contains('tema-escuro')) {
            localStorage.setItem('tema', 'escuro');
        } else {
            localStorage.setItem('tema', 'claro');
        }
    });

    const savedTheme = localStorage.getItem('tema');
    if (savedTheme === 'escuro') {
        bodyElement.classList.remove('tema-claro');
        bodyElement.classList.add('tema-escuro');
    } else {
        bodyElement.classList.remove('tema-escuro');
        bodyElement.classList.add('tema-claro');
    }
});