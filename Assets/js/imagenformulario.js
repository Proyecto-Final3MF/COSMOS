const inputArchivo = document.getElementById('imagen');
const nombreArchivoSpan = document.getElementById('nombre-archivo-seleccionado');

inputArchivo.addEventListener('change', () => {
    if (inputArchivo.files.length > 0) {
        nombreArchivoSpan.textContent = 'Archivo seleccionado: ' + inputArchivo.files[0].name;
    } else {
        nombreArchivoSpan.textContent = '';
    }
});