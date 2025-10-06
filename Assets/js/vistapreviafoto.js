document.addEventListener('DOMContentLoaded', function() {
    const inputImagen = document.getElementById('imagen');
    const nombreArchivo = document.getElementById('nombre-archivo-seleccionado');
    const vistaPrevia = document.getElementById('vista-previa');

    if (inputImagen) {
        inputImagen.addEventListener('change', function() {
            const archivo = this.files[0];
            if (archivo) {
                nombreArchivo.textContent = archivo.name;

                const lector = new FileReader();
                lector.onload = function(e) {
                    vistaPrevia.src = e.target.result;
                };
                lector.readAsDataURL(archivo);
            } else {
                nombreArchivo.textContent = 'Ningún archivo seleccionado';
                vistaPrevia.src = './Assets/img/default.jpg';
            }
        });
    }
});
