document.addEventListener("DOMContentLoaded", () => {
  const btnVolver = document.getElementById("btnVolver");

  if (btnVolver) {
    btnVolver.addEventListener("click", (e) => {
      e.preventDefault();

      // Animación (usa las clases que ya tienes en tu CSS)
      document.body.classList.remove("fade-in");
      document.body.classList.add("fade-out");

      setTimeout(() => {
        // Redirige siempre al mismo lugar
        window.location.href = "index.php?accion=redireccion";
      }, 500); // ajusta al mismo tiempo que tu transición CSS
    });
  }
});
