import './bootstrap';
import 'path/to/your/css/custom.css'; // Asegúrate de que la ruta sea correcta

// =============== SISTEMA DE TEMAS SIMPLE ===============
document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    // Cambia el tema y guarda preferencia
    function setTheme(theme) {
        body.classList.remove('theme-light', 'theme-dark', 'theme-high-contrast');
        body.classList.add('theme-' + theme);
        localStorage.setItem('theme', theme);
    }
    // Al cargar, aplica preferencia o default
    let preferredTheme = localStorage.getItem('theme');
    if (!preferredTheme || !['light','dark','high-contrast'].includes(preferredTheme)) {
        preferredTheme = 'light';
    }
    setTheme(preferredTheme);

    // =============== RELOJ Y FECHA DINÁMICOS ===============
    function pad(num) { return num.toString().padStart(2, '0'); }
    function updateClock() {
        const now = new Date();
        const hora = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
        const fecha = now.toLocaleDateString('es-ES', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
        const labelTime = document.getElementById('label-time');
        const labelDate = document.getElementById('label-date');
        if (labelTime) labelTime.textContent = hora;
        if (labelDate) labelDate.textContent = fecha.charAt(0).toUpperCase() + fecha.slice(1);
    }
    updateClock();
    setInterval(updateClock, 1000);
});
