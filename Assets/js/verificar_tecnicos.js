function mostrarEvidencia(ruta) {
    document.getElementById('imgEvidenciaAmpliada').src = ruta;
    document.getElementById('modalEvidencia').style.display = "block";
}

function cerrarEvidencia() {
    document.getElementById('modalEvidencia').style.display = "none";
}

window.onclick = function(event) {
    if (event.target == document.getElementById('modalEvidencia')) {
        cerrarEvidencia();
    }
}