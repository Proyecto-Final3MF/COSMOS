document.addEventListener('DOMContentLoaded', function() {
    const toggleTemaBtn = document.getElementById('toggleTemaBtn');
    const bodyElement = document.body;

    toggleTemaBtn.addEventListener('click', function() {
        bodyElement.classList.toggle('tema-claro');
        bodyElement.classList.toggle('tema-oscuro');
        if (bodyElement.classList.contains('tema-oscuro')) {
            localStorage.setItem('tema', 'oscuro');
        } else {
            localStorage.setItem('tema', 'claro');
        }
    });

    const savedTheme = localStorage.getItem('tema');
    if (savedTheme === 'oscuro') {
        bodyElement.classList.remove('tema-claro');
        bodyElement.classList.add('tema-oscuro');
    } else {
        bodyElement.classList.remove('tema-oscuro');
        bodyElement.classList.add('tema-claro');
    }
});