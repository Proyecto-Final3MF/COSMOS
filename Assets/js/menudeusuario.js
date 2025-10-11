document.addEventListener('DOMContentLoaded', function () {
  // selectores específicos para que no choquen con otros botones
  const userBtn = document.querySelector('.user-menu-container .dropdown-button');
  const rolBtn = document.querySelector('.menu-rol-container .dropdown-button');
  const userMenu = document.getElementById('userDropdown');
  const rolMenu = document.getElementById('rolDropdown');

  function closeAll() {
    if (userMenu) userMenu.classList.remove('show');
    if (rolMenu) rolMenu.classList.remove('show');
  }

  // open/close menú usuario
  if (userBtn && userMenu) {
    userBtn.addEventListener('click', function (e) {
      e.stopPropagation(); // important: evita que el click suba y cierre el menú
      const opened = userMenu.classList.toggle('show');
      if (opened && rolMenu) rolMenu.classList.remove('show');
    });
  }

  // open/close menú rol
  if (rolBtn && rolMenu) {
    rolBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      const opened = rolMenu.classList.toggle('show');
      if (opened && userMenu) userMenu.classList.remove('show');
    });
  }

  // clic fuera cierra menús (usa closest para detectar clicks en hijos)
  document.addEventListener('click', function (e) {
    if (!e.target.closest('.user-menu-container') && !e.target.closest('.menu-rol-container')) {
      closeAll();
    }
  });

  // Escape para cerrar
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeAll();
  });

  // Por si ya hay alguna clase inline onclick antigua, evita duplicados:
  // (no es obligatorio, pero evita conflictos)
  if (userBtn) userBtn.removeAttribute('onclick');
  if (rolBtn) rolBtn.removeAttribute('onclick');
});
