// Archivo: Assets/js/tecnico_registro.js

document.addEventListener('DOMContentLoaded', function() {
    const rolInput = document.getElementById('rol');
    const tecnicoFields = document.getElementById('tecnico-fields');
    const rolOptions = document.querySelectorAll('.rol-option');
    
    const especialidadSelector = document.getElementById('especialidad_selector');
    const especialidadesTagsContainer = document.getElementById('especialidades_tags');
    const especializacionesIdsInput = document.getElementById('especializaciones_seleccionadas');
    const evidenciaInput = document.getElementById('foto_evidencia');
    const evidenciaPreview = document.getElementById('preview-evidencia');
    const evidenciaLabelSpan = document.querySelector('.nombre-archivo-seleccionado-evidencia');
    
    // El ID del rol 'Tecnico' (asumiendo que es 1 según tu INSERT INTO)
    const ROL_TECNICO_ID = '1'; 

    let selectedEspecialidades = new Map(); // Map(id => nombre) para gestionar especializaciones

    // ----------------------------------------------------
    // Lógica para mostrar/ocultar campos de Técnico al seleccionar el rol
    // ----------------------------------------------------
    rolOptions.forEach(option => {
        option.addEventListener('click', function() {
            const selectedRolId = this.getAttribute('data-value');

            if (selectedRolId === ROL_TECNICO_ID) {
                // Muestra los campos, el estilo 'display: none' se cambia a 'display: block'
                tecnicoFields.style.display = 'block';
                // Hace que el campo de evidencia sea requerido
                evidenciaInput.setAttribute('required', 'required');
            } else {
                // Oculta los campos
                tecnicoFields.style.display = 'none';
                // Elimina el requisito de la evidencia
                evidenciaInput.removeAttribute('required');
                
                // Opcional: limpiar selecciones y previews
                selectedEspecialidades.clear();
                updateEspecialidadesView();
                // Limpiar preview de evidencia si el usuario cambia a Cliente
                evidenciaPreview.src = 'Assets/imagenes/perfil/fotodefault.webp'; 
                evidenciaLabelSpan.textContent = 'Ningún archivo seleccionado';
                evidenciaInput.value = ''; // Limpiar el archivo seleccionado
            }
        });
    });


    $('#especialidad_selector').select2({
        // ACORTAR ESTE TEXTO si es demasiado largo
        placeholder: "Selecciona especialidades", 
        allowClear: true 
    });

    // ----------------------------------------------------
    // Lógica para la selección de especialidades como tags (etiquetas)
    // ----------------------------------------------------

    especialidadSelector.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const id = selectedOption.value;
        const nombre = selectedOption.textContent;

        if (id && !selectedEspecialidades.has(id)) {
            selectedEspecialidades.set(id, nombre);
            updateEspecialidadesView();
        }
        // Restablece el selector para permitir seleccionar de nuevo la misma opción si se desea
        this.value = ""; 
    });

    // Función para actualizar el HTML de las tags y el input oculto
    // Asumiendo que esta es la función que maneja la vista de especialidades
    function updateEspecialidadesView(selectedRolId) {
        const tecnicoFields = document.getElementById('tecnico-fields');
        const especialidadSelector = document.getElementById('especialidad_selector');
        const fotoEvidencia = document.getElementById('foto_evidencia');
        
        // Asumimos que ROL_TECNICO es 1
        const ROL_TECNICO = '1'; 

        if (selectedRolId === ROL_TECNICO) {
            // 1. Mostrar campos de Técnico
            if (tecnicoFields) tecnicoFields.classList.remove('hidden-fields');
            
            // 2. Aplicar 'required'
            if (especialidadSelector) especialidadSelector.required = true;
            if (fotoEvidencia) fotoEvidencia.required = true;
            
        } else {
            // 1. Ocultar campos de Técnico
            if (tecnicoFields) tecnicoFields.classList.add('hidden-fields');
            
            // 2. Remover 'required' y limpiar
            if (especialidadSelector) {
                especialidadSelector.required = false;
                // Deseleccionar todas las opciones si usa Select2
                // Usar jQuery si estás usando Select2: $('#especialidad_selector').val(null).trigger('change');
                // Si solo es HTML:
                for (let i = 0; i < especialidadSelector.options.length; i++) {
                    especialidadSelector.options[i].selected = false;
                }
            }
            
            if (fotoEvidencia) {
                fotoEvidencia.required = false;
                // Limpiar el campo de archivo (estableciendo su valor a null)
                fotoEvidencia.value = null; 
            }
            
            // 3. Limpiar el texto de 'Otra Especialidad'
            const otraEspecialidad = document.getElementById('otra_especialidad');
            if (otraEspecialidad) otraEspecialidad.value = '';
            
            // 4. Limpiar la vista de tags (si la tienes implementada)
            const especialidadesTags = document.getElementById('especialidades_tags');
            if (especialidadesTags) especialidadesTags.innerHTML = ''; 
        }
        
        // Asegúrate de que esta línea exista y sea la que lanza el error:
        // La línea 96 probablemente es la que actualiza el campo oculto #rol
        const rolInput = document.getElementById('rol');
        if (rolInput) {
            rolInput.value = selectedRolId; // Línea que debe ser segura
        }
    }

    // Lógica para el nombre del archivo de perfil (para el input de perfil)
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
