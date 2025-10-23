document.addEventListener('DOMContentLoaded', function() {
    const rolOptions = document.querySelectorAll('.rol-option');
    const rolInput = document.getElementById('rol');
    const tecnicoFields = document.getElementById('tecnico-fields');
    const especialidadSelector = document.getElementById('especialidad_selector');
    const fotoEvidenciaInput = document.getElementById('foto_evidencia');
    
    const ROL_TECNICO_ID = '1'; // Ensure this matches the data-value for the Technician role

    rolOptions.forEach(option => {
        option.addEventListener('click', () => {
            // 1. Reset 'active' class on all options
            rolOptions.forEach(o => o.classList.remove('active'));

            // 2. Mark the selected option
            option.classList.add('active');

            // 3. Get the Role ID (data-value)
            const rolId = option.dataset.value;

            // 4. Update the hidden input value (CRUCIAL FIX)
            rolInput.value = rolId;

            // 5. Manage Technician-specific fields
            if (rolId === ROL_TECNICO_ID) {
                // Show Technician fields
                tecnicoFields.classList.remove('hidden-fields');
                
                // Set fields as REQUIRED for Technician registration
                especialidadSelector.setAttribute('required', 'required');
                fotoEvidenciaInput.setAttribute('required', 'required');
            } else {
                // Hide Technician fields
                tecnicoFields.classList.add('hidden-fields');
                
                // Remove 'required' for all other roles (Client, Admin, etc.)
                especialidadSelector.removeAttribute('required');
                fotoEvidenciaInput.removeAttribute('required');
            }
        });
    });

    // Optional: Add logic to handle the initial state on page load 
    // to ensure no fields are marked 'required' initially unless a default role is selected.
    
    // Initial check: if no role is selected, ensure Technician fields are hidden
    if (rolInput.value === '') {
        tecnicoFields.classList.add('hidden-fields');
    }
});