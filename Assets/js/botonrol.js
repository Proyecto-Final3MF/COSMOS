const rolOptions = document.querySelectorAll('.rol-option');
    const rolInput = document.getElementById('rol');

    rolOptions.forEach(option => {
        option.addEventListener('click', () => {
            // Quita la selección anterior
            rolOptions.forEach(o => o.classList.remove('active'));

            // Marca la seleccionada
            option.classList.add('active');

            // Actualiza el valor oculto
            rolInput.value = option.dataset.value;
        });
    });