import Alpine from 'alpinejs'
import { initRGPD } from './rgpd';

window.Alpine = Alpine;

window.addEventListener('DOMContentLoaded', () => {
    initRGPD();
    Alpine.start();
});