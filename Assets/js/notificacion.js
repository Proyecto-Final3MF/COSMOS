document.addEventListener('DOMContentLoaded', function() {
    const notiDiv = document.getElementById('notificaciones');
    const dropdown = notiDiv.querySelector('.dropdown');
    const contador = document.getElementById('notifContador');

    function cerrarDropdown() {
        dropdown.style.display = 'none';
    }

    function toggleDropdown() {
        if (dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
        } else {
            dropdown.style.display = 'block';
            if (contador) {
                // Llamada AJAX para marcar como leídas
                fetch("Controllers/ajax_notificaciones.php", { method: "POST" })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && contador) {
                            contador.remove();
                        }
                    })
                    .catch(err => console.error("Error al marcar notificaciones:", err));
            }
        }
    }

    if (notiDiv) {
        notiDiv.querySelector('i').addEventListener('click', toggleDropdown);
    }

    // Cerrar dropdown al hacer click fuera
    document.addEventListener('click', function(e) {
        if (!notiDiv.contains(e.target)) {
            cerrarDropdown();
        }
    });
});
