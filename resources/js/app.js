import Swal from 'sweetalert2';
import { loadGoogleMapsLibraries } from './google-maps';

window.upcomingProvider = () => Swal.fire({ icon: 'info', title: 'Próximamente disponible', text: 'Estamos preparando este acceso seguro para ti.', confirmButtonColor: '#C65A3A' });
window.alertaPetGoogleMaps = { loadGoogleMapsLibraries };
window.dispatchEvent(new Event('alertapet:google-maps-loader-ready'));

const themeToggle = document.querySelector('[data-theme-toggle]');
const systemTheme = window.matchMedia('(prefers-color-scheme: dark)');

const applyTheme = (theme, persist = false) => {
    document.documentElement.dataset.theme = theme;
    window.dispatchEvent(new CustomEvent('alertapet:theme-changed', { detail: { theme } }));
    themeToggle?.setAttribute('aria-pressed', String(theme === 'dark'));
    themeToggle?.setAttribute('aria-label', theme === 'dark' ? 'Activar modo claro' : 'Activar modo oscuro');
    document.querySelectorAll('[data-theme-icon]').forEach((icon) => {
        icon.className = theme === 'dark' ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
    });
    document.querySelectorAll('[data-theme-label]').forEach((label) => {
        label.textContent = theme === 'dark' ? 'Modo claro' : 'Modo oscuro';
    });

    if (persist) {
        localStorage.setItem('alertapet-theme', theme);
    }
};

applyTheme(document.documentElement.dataset.theme);

themeToggle?.addEventListener('click', () => {
    applyTheme(document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark', true);
});

systemTheme.addEventListener('change', (event) => {
    if (!localStorage.getItem('alertapet-theme')) {
        applyTheme(event.matches ? 'dark' : 'light');
    }
});
