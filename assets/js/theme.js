document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('themeToggleBtn');
  const iconLight = document.getElementById('iconLight');
  const iconDark = document.getElementById('iconDark');
  const html = document.documentElement;
  const tabulatorStyle = document.getElementById('tabulator-theme');

  if (!btn || !iconLight || !iconDark || !tabulatorStyle) return;

  const tabulatorThemes = {
    light: BASE_URL + 'assets/tabulator/css/tabulator.min.css',
    dark: BASE_URL + 'assets/tabulator/css/tabulator_site_dark.min.css'
  };

  let theme = localStorage.getItem('theme') || 'light';
  applyTheme(theme);

  btn.addEventListener('click', () => {
    theme = (theme === 'light') ? 'dark' : 'light';
    localStorage.setItem('theme', theme);
    applyTheme(theme);
  });

  function applyTheme(theme) {
    html.setAttribute('data-bs-theme', theme);
    iconLight.classList.toggle('d-none', theme === 'dark');
    iconDark.classList.toggle('d-none', theme === 'light');
    tabulatorStyle.setAttribute('href', tabulatorThemes[theme]);

    // Safe redraw for one or many Tabulator tables
    if (typeof Tabulator !== 'undefined') {
      const tables = Tabulator.findTable('.tabulator');
      if (Array.isArray(tables)) {
        tables.forEach(table => table.redraw(true));
      } else if (tables) {
        tables.redraw(true);
      }
    }
  }
});
