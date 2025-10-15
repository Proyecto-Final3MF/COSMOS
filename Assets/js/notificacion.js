 const notificacionesDiv = document.getElementById('notificaciones');
const dropdown = notificacionesDiv.querySelector('.dropdown');
const contador = document.getElementById('notifContador');

notificacionesDiv.addEventListener('click', function(event){
    event.stopPropagation();
    dropdown.classList.toggle('show');

    if(contador) {
        // AJAX para marcar notificaciones como leídas
        fetch('index.php?accion=marcarNotificacionesLeidas')
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    contador.remove(); // eliminar contador
                }
            });
    }
});

// Cerrar dropdown si se hace click fuera
document.addEventListener('click', function(){
    dropdown.classList.remove('show');
});
