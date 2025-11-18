document.addEventListener('DOMContentLoaded', function() {
    // Event listener para abrir el modal
    document.getElementById('link-terminos-cliente').addEventListener('click', function(event) {
        event.preventDefault();  // Previene cualquier navegación
        abrirModalTerminosCliente();
    });
    // Event listener para cerrar el modal (botón X)
    document.getElementById('close-modal-terminos-cliente').addEventListener('click', function() {
        cerrarModalTerminosCliente();
    });
});
function abrirModalTerminosCliente() {
    // Cargar contenido vía AJAX
    fetch('Index.php?accion=terminos')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('modal-terminos-body-cliente').innerHTML = data;
            document.getElementById('modal-terminos-cliente').style.display = 'flex';  // Usa 'flex' para centrar
        })
        .catch(error => {
            console.error('Error al cargar términos:', error);
            document.getElementById('modal-terminos-body-cliente').innerHTML = '<p>Error al cargar los términos. Verifica tu conexión e inténtalo de nuevo.</p>';
            document.getElementById('modal-terminos-cliente').style.display = 'flex';
        });
}

function cerrarModalTerminosCliente() {
    document.getElementById('modal-terminos-cliente').style.display = 'none';
}
// Cerrar modal al hacer clic fuera de él
window.addEventListener('click', function(event) {
    if (event.target === document.getElementById('modal-terminos-cliente')) {
        cerrarModalTerminosCliente();
    }
});
