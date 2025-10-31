document.addEventListener("scroll", function() {
  const reveals = document.querySelectorAll(".reveal");

  reveals.forEach((elemento) => {
    const windowHeight = window.innerHeight;
    const elementTop = elemento.getBoundingClientRect().top;
    const revealPoint = 120; // mientras más bajo, antes aparece

    if (elementTop < windowHeight - revealPoint) {
      elemento.classList.add("active");
    } else {
      elemento.classList.remove("active");
    }
  });
});
