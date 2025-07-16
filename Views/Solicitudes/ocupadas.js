

document.addEventListener('DOMContentLoaded', function() {
    const changeStatusButtons = document.querySelectorAll('.change-status-btn');

    changeStatusButtons.forEach(button => {
        button.addEventListener('click', function() {
            const solicitudId = this.dataset.solicitudId;
            const selectElement = document.getElementById(`new_estado_${solicitudId}`);
            const newEstadoId = selectElement.value;
            const newEstadoText = selectElement.options[selectElement.selectedIndex].text;
            const statusMessageDiv = document.getElementById(`message_${solicitudId}`);
            const currentEstadoSpan = this.closest('.solicitud').querySelector('.current-estado');

            statusMessageDiv.textContent = ''; // Clear previous messages
            statusMessageDiv.className = 'status-message'; // Reset classes

            fetch('change_solicitud_status.php', { // This is the PHP endpoint for status updates
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    solicitud_id: solicitudId,
                    new_estado_id: newEstadoId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusMessageDiv.textContent = 'Estado actualizado con éxito.';
                    statusMessageDiv.classList.add('success');
                    currentEstadoSpan.textContent = newEstadoText; // Update the displayed status
                    // Optionally, re-filter or re-fetch data if the status change affects the current view
                    // window.location.reload(); // Uncomment to refresh the page after update
                } else {
                    statusMessageDiv.textContent = 'Error al actualizar el estado: ' + data.message;
                    statusMessageDiv.classList.add('error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                statusMessageDiv.textContent = 'Error de conexión o del servidor.';
                statusMessageDiv.classList.add('error');
            });
        });
    });

    // Existing filter logic (assuming it's also in listado.js or was intended to be here)
    const filterButtons = document.querySelectorAll('.filter-buttons button');
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;
            window.location.href = `ocupadas.php?estado=${filter}`;
        });
    });
});