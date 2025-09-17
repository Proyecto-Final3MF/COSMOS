const translations = {
    'en': {
        start: "Start Now",
        p: "We help you find a technician to fix your device in record time.",
        h1: "Welcome to COSMOS"
    },
    'es': {
        start: "Empezar Ahora",
        p: "Te ayudamos a encontrar un tecnico para arreglar tu dispositivo en tiempo record",
        h1: "Bienvenido a COSMOS"
    }
};

function applyTranslations(lang) {
    document.querySelectorAll('[data-translate]').forEach(element => {
        const key = element.getAttribute('data-translate');
        if (translations[lang] && translations[lang][key]) {
            if (element.tagName === 'TITLE') {
                document.title = translations[lang][key];
            } else {
                element.textContent = translations[lang][key];
            }
        }
    });
}

function changeLanguage(lang) {
    localStorage.setItem('userLanguage', lang);
    document.documentElement.lang = lang;
    applyTranslations(lang);
}

document.addEventListener('DOMContentLoaded', () => {
    let userPreferredLanguage = localStorage.getItem('userLanguage');
    if (!userPreferredLanguage) {
        const browserLanguage = navigator.language || navigator.userLanguage;
        const shortBrowserLanguage = browserLanguage.split('-')[0];

        if (translations[browserLanguage]) {
            userPreferredLanguage = browserLanguage;
        } else if (translations[shortBrowserLanguage]) {
            userPreferredLanguage = shortBrowserLanguage;
        } else {
            userPreferredLanguage = 'es';
        }
    }
    changeLanguage(userPreferredLanguage);
});

const languageSelect = document.getElementById('language-select');
    if (languageSelect) {
        languageSelect.addEventListener('change', (event) => {
            const selectedLanguage = event.target.value;
            changeLanguage(selectedLanguage);
        });
    }

    let userPreferredLanguage = localStorage.getItem('userLanguage') || 'es';
    if (languageSelect) {
        languageSelect.value = userPreferredLanguage;
    }