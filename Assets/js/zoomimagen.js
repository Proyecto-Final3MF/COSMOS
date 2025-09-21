
  // Modal
  const modal = document.getElementById("imageModal");
  const modalImg = document.getElementById("modalImage");
  const closeBtn = document.querySelector(".image-modal .close");

  // Cuando se hace clic en cualquier imagen con la clase zoom-img
  document.querySelectorAll(".zoom-img").forEach(img => {
    img.addEventListener("click", function() {
      modal.style.display = "block";
      modalImg.src = this.src;
    });
  });

  // Cerrar al hacer clic en la X
  closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  // Cerrar al hacer clic fuera de la imagen
  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.style.display = "none";
    }
  });

