document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('themeToggleBtn');
    if (!btn) return; // Si no existe, salimos sin errores
  
    const iconLight = document.getElementById('iconLight');
    const iconDark  = document.getElementById('iconDark');
    const html      = document.documentElement;
  
    // Estado inicial
    let theme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-bs-theme', theme);
    iconLight.classList.toggle('d-none', theme === 'dark');
    iconDark.classList.toggle('d-none', theme === 'light');
  
    // Al hacer clic, alternar
    btn.addEventListener('click', () => {
      theme = (theme === 'light') ? 'dark' : 'light';
      html.setAttribute('data-bs-theme', theme);
      localStorage.setItem('theme', theme);
      iconLight.classList.toggle('d-none');
      iconDark.classList.toggle('d-none');
    });
  });