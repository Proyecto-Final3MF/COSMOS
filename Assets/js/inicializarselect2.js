document.addEventListener('DOMContentLoaded', function() {
    // Usamos jQuery (requerido por Select2) para seleccionar el elemento.
    $('#categoria').select2({
        placeholder: "Escriba o seleccione el tipo de equipo (Ej: Laptop)", 
        allowClear: true, // Permite borrar la selección
        theme: 'bootstrap', // Tema moderno que se adapta mejor a tus estilos
        width: '100%', // Ancho completo para que coincida con otros inputs
        language: {
            noResults: function() {
                return "No se encontraron resultados"; // Mensaje personalizado en español
            }
        }
    });
});