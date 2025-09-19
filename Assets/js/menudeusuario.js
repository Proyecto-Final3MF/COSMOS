
    document.addEventListener('DOMContentLoaded', () => {
        const dropdownBtn = document.getElementById('dropdown-btn');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const deleteBtn = document.getElementById('delete-btn');
        const deleteModal = document.getElementById('delete-modal');
        const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
        const confirmDeleteLink = document.getElementById('confirm-delete-link');

        // Toggle del menú desplegable
        dropdownBtn.addEventListener('click', () => {
            dropdownMenu.classList.toggle('visible');
        });

        // Cerrar el menú si se hace clic fuera
        document.addEventListener('click', (event) => {
            if (!dropdownBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('visible');
            }
        });

        // Mostrar el modal de confirmación
        deleteBtn.addEventListener('click', (event) => {
            event.preventDefault();
            deleteModal.style.display = 'flex';
        });

        // Cerrar el modal
        cancelDeleteBtn.addEventListener('click', () => {
            deleteModal.style.display = 'none';
        });
    });
