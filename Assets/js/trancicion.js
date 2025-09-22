document.addEventListener("DOMContentLoaded", () => {
  // Fade in al cargar
  document.body.classList.add("fade-in");

  // Seleccionamos todos los enlaces internos
  const links = document.querySelectorAll("a");

  links.forEach(link => {
    link.addEventListener("click", e => {
      // Solo enlaces internos
      if (link.hostname === window.location.hostname) {
        e.preventDefault();

        // Fade out
        document.body.classList.remove("fade-in");
        document.body.classList.add("fade-out");

        // Cambia de página después de la transición
        setTimeout(() => {
          window.location.href = link.href;
        }, 500); // coincide con transition en CSS
      }
    });
  });

  // Seguridad: si no hay enlaces, aseguramos que el body esté visible
  setTimeout(() => {
    document.body.classList.add("fade-in");
  }, 100);
});
