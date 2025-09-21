
document.addEventListener("DOMContentLoaded", () => {
  // Hacemos fade in al cargar la página
  document.body.classList.add("fade-in");

  // Seleccionamos todos los enlaces internos
  const links = document.querySelectorAll("a");

  links.forEach(link => {
    link.addEventListener("click", e => {
      // Solo para enlaces que llevan a otra página de tu sitio
      if (link.hostname === window.location.hostname) {
        e.preventDefault(); // evitamos navegación inmediata
        document.body.classList.remove("fade-in");
        document.body.classList.add("fade-out");

        // Esperamos la duración del fade y luego cambiamos de página
        setTimeout(() => {
          window.location.href = link.href;
        }, 500); // coincide con el transition en CSS
      }
    });
  });
});
