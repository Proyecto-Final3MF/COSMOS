document.addEventListener('DOMContentLoaded', function() {
  // Recorre todos los contenedores .input-archivo (soporta varios formularios en la misma página)
  document.querySelectorAll('.input-archivo').forEach(container => {
    const input = container.querySelector('input[type="file"]');
    if (!input) return;

    // Busca un span dentro del mismo container (prefiere la clase, si no existe busca id o el primer span)
    let nombreSpan = container.querySelector('.nombre-archivo-seleccionado')
                  || container.querySelector('#nombre-archivo-seleccionado')
                  || container.querySelector('span');

    // Intenta encontrar la imagen de preview: prioriza una <img> con id="preview" dentro del formulario
    // Si tenés más de un preview por página, ponles ids únicos (ej: preview-register, preview-edit)
    const preview = document.getElementById('preview');

    input.addEventListener('change', function() {
      if (this.files && this.files.length > 0) {
        const file = this.files[0];
        if (nombreSpan) nombreSpan.textContent = 'Archivo seleccionado: ' + file.name;

        // Actualiza preview (si existe)
        if (preview) {
          const reader = new FileReader();
          reader.onload = function(e) {
            preview.setAttribute('src', e.target.result);
            preview.style.display = 'block';
          };
          reader.readAsDataURL(file);
        }
      } else {
        if (nombreSpan) nombreSpan.textContent = 'Ningún archivo seleccionado';
        if (preview) preview.style.display = 'none';
      }
    });
  });
});
