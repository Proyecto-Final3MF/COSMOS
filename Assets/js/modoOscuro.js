document.addEventListener('DOMContentLoaded', function() {
  const togglethemeBtn = document.getElementById('togglethemeBtn');
  const bodyElement = document.body;

  togglethemeBtn.addEventListener('click', function() {
    bodyElement.classList.toggle('light-mode');
    bodyElement.classList.toggle('dark-mode');

    if (bodyElement.classList.contains('dark-mode')) {
      localStorage.setItem('theme', 'dark');
      togglethemeBtn.innerHTML = '<i class="fa-solid fa-sun"></i>';
    } else {
      localStorage.setItem('theme', 'claro');
      togglethemeBtn.innerHTML = '<i class="fa-solid fa-moon"></i>';
    }
  });

  const savedTheme = localStorage.getItem('theme');
  if (savedTheme === 'dark') {
    bodyElement.classList.add('dark-mode');
    togglethemeBtn.innerHTML = '<i class="fa-solid fa-sun"></i>';
  } else {
    bodyElement.classList.add('light-mode');
    togglethemeBtn.innerHTML = '<i class="fa-solid fa-moon"></i>';
  }
});
