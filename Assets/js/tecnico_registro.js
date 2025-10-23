document.addEventListener('DOMContentLoaded', function() {
    // DECLARACIONES DE CONSTANTES Y ELEMENTOS (Una sola vez)
    const rolOptions = document.querySelectorAll('.rol-option');
    const rolInput = document.getElementById('rol');
    const tecnicoFields = document.getElementById('tecnico-fields');
    const especialidadSelector = document.getElementById('especialidad_selector');
    const fotoEvidenciaInput = document.getElementById('foto_evidencia');
    const evidenciaPreview = document.getElementById('preview-evidencia');
    const evidenciaLabelSpan = document.querySelector('.nombre-archivo-seleccionado-evidencia');
    const otraEspecialidadInput = document.getElementById('otra_especialidad');
    const especialidadesTagsContainer = document.getElementById('especialidades_tags'); // Asumiendo que existe
    
    // Asumiendo que ROL_TECNICO es 1 y ROL_CLIENTE es 2
    const ROL_TECNICO_ID = '1'; 
    
    let selectedEspecialidades = new Map();

    // ----------------------------------------------------
    // LÓGICA PRINCIPAL DE SELECCIÓN DE ROL (Asegurando la Asignación de rolInput.value)
    // ----------------------------------------------------
    rolOptions.forEach(option => {
        option.addEventListener('click', function() { // Usamos 'function' para usar 'this'
            // 1. Manejo visual y de ID
            rolOptions.forEach(o => o.classList.remove('active'));
            this.classList.add('active'); // Usa 'this' para la opción clicada
            const selectedRolId = this.getAttribute('data-value');

            // 2. 🎯 CRUCIAL: ASIGNAR EL VALOR AL INPUT OCULTO
            rolInput.value = selectedRolId; 

            // 3. Manejar campos específicos del Técnico
            if (selectedRolId === ROL_TECNICO_ID) {
                // Muestra y aplica 'required'
                tecnicoFields.classList.remove('hidden-fields');
                tecnicoFields.style.display = 'block'; // Usar block si estás usando style.display
                especialidadSelector.setAttribute('required', 'required');
                fotoEvidenciaInput.setAttribute('required', 'required');
            } else {
                // Oculta y remueve 'required' para el Cliente (ID 2)
                tecnicoFields.classList.add('hidden-fields');
                tecnicoFields.style.display = 'none'; // Usa none para ocultar
                especialidadSelector.removeAttribute('required');
                fotoEvidenciaInput.removeAttribute('required');
                
                // Limpieza de campos del Técnico para evitar enviar datos basura con el Cliente
                if (otraEspecialidadInput) otraEspecialidadInput.value = '';
                if (evidenciaPreview) evidenciaPreview.src = 'Assets/imagenes/perfil/fotodefault.webp'; 
                if (evidenciaLabelSpan) evidenciaLabelSpan.textContent = 'Ningún archivo seleccionado';
                if (fotoEvidenciaInput) fotoEvidenciaInput.value = '';
                
                // Limpiar la vista y selecciones del Select2
                if (typeof jQuery !== 'undefined' && $('#especialidad_selector').data('select2')) {
                    $('#especialidad_selector').val(null).trigger('change');
                }
                selectedEspecialidades.clear();
                if (especialidadesTagsContainer) especialidadesTagsContainer.innerHTML = '';
            }
        });
    });

    // ----------------------------------------------------
    // Lógica de Select2 y Tags
    // ----------------------------------------------------
    if (typeof jQuery !== 'undefined') {
        $('#especialidad_selector').select2({
            placeholder: "Selecciona especialidades", 
            allowClear: true 
        });
    }

    // El resto de tu lógica de especialidadesTags, actualización de vista, y foto de perfil.
    // ... (El código aquí abajo debería ser el resto de tu segundo bloque) ...

    // Lógica para la selección de especialidades como tags (etiquetas)
    especialidadSelector.addEventListener('change', function() {
        // ... tu lógica de manejo de tags ...
    });

    // Lógica para el nombre del archivo de perfil
    const perfilInput = document.getElementById('foto_perfil');
    const perfilLabelSpan = document.querySelector('.nombre-archivo-seleccionado');

    if (perfilInput) {
        perfilInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                perfilLabelSpan.textContent = this.files[0].name;
            } else {
                perfilLabelSpan.textContent = 'Ningúna Foto seleccionada';
            }
        });
    }

    if (rolInput.value === '') {
        tecnicoFields.classList.add('hidden-fields');
        tecnicoFields.style.display = 'none';
    }

    const form = document.querySelector('form'); // Asume que solo hay un formulario en la página

    if (form) {
        form.addEventListener('submit', function(event) {
            // Verifica si el campo de rol está vacío o es 0
            if (rolInput.value === '' || rolInput.value === '0') {
                
                // Intenta encontrar la opción seleccionada (solo por si acaso la variable rolInput.value falló)
                const selectedOption = document.querySelector('.rol-option.active');
                
                if (selectedOption) {
                    // Si se encontró una opción activa, fuerza su valor al input oculto
                    rolInput.value = selectedOption.dataset.value;
                    
                    // Doble verificación: si es Cliente, fuerza el 2
                    if (rolInput.value !== ROL_TECNICO_ID) {
                        rolInput.value = '2'; // Forzar a '2' si no es Técnico
                    }
                } else {
                    // Si no hay rol seleccionado, cancela el envío del formulario
                    event.preventDefault(); 
                    alert("Por favor, selecciona si eres Técnico o Cliente.");
                    return false; // Evita el envío
                }
            }
            // Si rolInput.value ya tiene '1' o '2', el formulario continúa.
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const inputEvidencia = document.getElementById('foto_evidencia');
    const nombreArchivoEvidencia = document.querySelector('.nombre-archivo-seleccionado-evidencia');
    const previewEvidencia = document.getElementById('preview-evidencia');

    if (inputEvidencia) {
        inputEvidencia.addEventListener('change', function() {
            const archivo = this.files[0];

            if (archivo) {
                nombreArchivoEvidencia.textContent = archivo.name;

                const lector = new FileReader();
                lector.onload = function(e) {
                    previewEvidencia.src = e.target.result;
                };
                lector.readAsDataURL(archivo);
            } else {
                nombreArchivoEvidencia.textContent = 'Ningún archivo seleccionado';
                previewEvidencia.src = './Assets/imagenes/sincargas4.png';
            }
        });
    }
});
