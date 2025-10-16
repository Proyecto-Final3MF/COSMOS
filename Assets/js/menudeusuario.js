document.addEventListener('DOMContentLoaded', function () {
    // ELEMENTOS
    const notiDiv = document.getElementById('notificaciones');
    const notiDropdown = notiDiv ? notiDiv.querySelector('.dropdown') : null;
    const notifContador = document.getElementById('notifContador');

    const userBtn = document.querySelector('.user-menu-container .dropdown-button');
    const userMenu = document.getElementById('userDropdown');

    const rolBtn = document.querySelector('.menu-rol-container .dropdown-button');
    const rolMenu = document.getElementById('rolDropdown');

    // FUNCIONES DE CIERRE
    function cerrarDropdowns() {
        if (notiDropdown) notiDropdown.style.display = 'none';
        if (userMenu) userMenu.classList.remove('show');
        if (rolMenu) rolMenu.classList.remove('show');
    }

    // TOGGLE NOTIFICACIONES
    if (notiDiv && notiDropdown) {
        notiDiv.querySelector('i').addEventListener('click', function (e) {
            e.stopPropagation();
            if (notiDropdown.style.display === 'block') {
                notiDropdown.style.display = 'none';
            } else {
                notiDropdown.style.display = 'block';

                if (notifContador) {
                    // AJAX para marcar notificaciones como leídas
                    fetch("Controllers/ajax_notificaciones.php", { method: "POST" })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && notifContador) {
                                notifContador.remove();
                            }
                        })
                        .catch(err => console.error("Error al marcar notificaciones:", err));
                }
            }
        });
    }

    // TOGGLE MENÚ USUARIO
    if (userBtn && userMenu) {
        userBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const opened = userMenu.classList.toggle('show');
            if (opened && rolMenu) rolMenu.classList.remove('show');
            if (opened && notiDropdown) notiDropdown.style.display = 'none';
        });
    }

    // TOGGLE MENÚ ROL
    if (rolBtn && rolMenu) {
        rolBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const opened = rolMenu.classList.toggle('show');
            if (opened && userMenu) userMenu.classList.remove('show');
            if (opened && notiDropdown) notiDropdown.style.display = 'none';
        });
    }

    // CLIC FUERA CIERRA TODOS LOS MENÚS
    document.addEventListener('click', function (e) {
        const menus = [
            notiDiv,
            document.querySelector('.user-menu-container'),
            document.querySelector('.menu-rol-container')
        ];
        const clickDentro = menus.some(menu => menu && menu.contains(e.target));
        if (!clickDentro) cerrarDropdowns();
    });

    // ESCAPE CIERRA TODOS LOS MENÚS
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') cerrarDropdowns();
    });
});
