import './bootstrap';

import flatpickr from "flatpickr"
import { Portuguese } from "flatpickr/dist/l10n/pt.js"

window.flatpickr = flatpickr
window.FlatpickrPortuguese = Portuguese

import Swal from 'sweetalert2'
window.Swal = Swal

import IMask from 'imask';
window.IMask = IMask;

import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import ptBrLocale from '@fullcalendar/core/locales/pt-br'

window.Calendar = Calendar
window.dayGridPlugin = dayGridPlugin
window.interactionPlugin = interactionPlugin
window.ptBrLocale = ptBrLocale

import Toastify from "toastify-js";
import "toastify-js/src/toastify.css";

window.Toastify = Toastify;

const toastColors = {
    success: '#16a34a',
    error: '#dc2626',
    warning: '#f59e0b',
    info: '#2563eb',
};

window.showToast = function (type, message) {
    if (!message) {
        return;
    }

    Toastify({
        text: message,
        duration: 4000,
        gravity: 'top',
        position: 'right',
        close: true,
        style: {
            background: toastColors[type] ?? '#2563eb',
        },
    }).showToast();
};

document.addEventListener('livewire:init', () => {
    Livewire.on('toast', (event) => {
        const data = event?.detail?.[0] ?? event;

        if (!data?.message) {
            return;
        }

        showToast(data.type, data.message);
    });
});

import mask from '@alpinejs/mask'

document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(mask);
})