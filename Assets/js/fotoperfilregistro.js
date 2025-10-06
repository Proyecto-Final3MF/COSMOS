    const inputFoto = document.getElementById('foto_perfil');
const preview = document.getElementById('preview');

inputFoto.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(file);
    } else {
        // Mantener la imagen por defecto
        preview.setAttribute('src', 'Assets/imagenes/default-user.png');
    }
});