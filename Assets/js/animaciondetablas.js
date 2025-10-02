function animateTable() {
  const rows = document.querySelectorAll(".list-item");
  let visibleIndex = 0;

  rows.forEach((row) => {
    if (row.style.display !== "none") { // solo filas visibles
      row.style.opacity = "0";
      row.style.animation = "none";
      setTimeout(() => {
        row.style.animation = `fadeInRow 0.6s ease forwards`;
        row.style.animationDelay = `${visibleIndex * 0.1}s`;
      }, 50);
      visibleIndex++;
    }
  });
}
