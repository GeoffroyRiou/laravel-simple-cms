import Alpine from 'alpinejs'
import { initRGPD } from './rgpd';

if (window.Alpine === undefined) {
    window.Alpine = Alpine;
    Alpine.start();
}

window.addEventListener('DOMContentLoaded', () => {
    initRGPD();
});