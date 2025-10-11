document.addEventListener('DOMContentLoaded', function() {
    // Usamos jQuery (requerido por Select2) para seleccionar el elemento.
    $('#categoria').select2({
        placeholder: "Escriba o seleccione el tipo de equipo (Ej: Laptop)", 
        allowClear: true // Permite borrar la selección
    });
}); 