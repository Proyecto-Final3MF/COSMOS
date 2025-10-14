document.addEventListener('DOMContentLoaded', function() {
    const togglethemeBtn = document.getElementById('togglethemeBtn');
    const bodyElement = document.body;

    togglethemeBtn.addEventListener('click', function() {
        bodyElement.classList.toggle('light-mode');
        bodyElement.classList.toggle('dark-mode');

        if (bodyElement.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'claro');
        }
    });

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        bodyElement.classList.remove('light-mode');
        bodyElement.classList.add('dark-mode');
    } else {
        bodyElement.classList.remove('dark-mode');
        bodyElement.classList.add('light-mode');
    }
});