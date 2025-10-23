function togglePassword(id, icon) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

// Validación de coincidencia de contraseñas
const pass = document.getElementById("contrasena");
const confirm = document.getElementById("confirmar_contrasena");
const errorText = document.getElementById("error-password");

if (confirm) {
    confirm.addEventListener("input", () => {
        if (confirm.value !== pass.value) {
            errorText.textContent = "La contraseña no coincide";
            errorText.style.color = "red";
        } else {
            errorText.textContent = "";
        }
    });
}


