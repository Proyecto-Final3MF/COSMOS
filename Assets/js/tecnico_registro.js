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
    function updateEspecialidadesView() {
        especialidadesTagsContainer.innerHTML = '';
        const ids = [];

        selectedEspecialidades.forEach((nombre, id) => {
            ids.push(id);
            const tag = document.createElement('span');
            // Nota: Aquí se añaden clases para que tu CSS pueda darles estilo
            tag.className = 'especializacion-tag'; 
            tag.innerHTML = `${nombre} <span class="close" data-id="${id}">&times;</span>`;
            
            // Lógica para remover la tag
            tag.querySelector('.close').addEventListener('click', function() {
                const removeId = this.getAttribute('data-id');
                selectedEspecialidades.delete(removeId);
                updateEspecialidadesView();
            });

            especialidadesTagsContainer.appendChild(tag);
        });

        // Actualiza el campo oculto que se enviará al servidor
        especializacionesIdsInput.value = ids.join(',');
    }
    
    // ----------------------------------------------------
    // Lógica para previsualización de la foto de Evidencia
    // ----------------------------------------------------
    evidenciaInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                evidenciaPreview.src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
            evidenciaLabelSpan.textContent = this.files[0].name;
        } else {
            evidenciaPreview.src = 'Assets/imagenes/perfil/fotodefault.webp'; // Restablece la imagen por defecto
            evidenciaLabelSpan.textContent = 'Ningún archivo seleccionado';
        }
    });

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