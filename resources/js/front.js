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

document.addEventListener('alpine:init', () => {
    Alpine.data('cookieConsent', () => ({
        open: false,
        accepted: false,
        stats: false,
        marketing: false,

        init() {
            const saved = localStorage.getItem('cookie_consent');
            if (saved) {
                const prefs = JSON.parse(saved);
                this.stats = prefs.stats ?? false;
                this.marketing = prefs.marketing ?? false;
                this.accepted = true;
            }
        },

        openModal() { this.open = true },
        closeModal() { this.open = false },

        acceptAll() {
            this.stats = true;
            this.marketing = true;
            this.save();
        },

        save() {
            localStorage.setItem('cookie_consent', JSON.stringify({
                stats: this.stats,
                marketing: this.marketing
            }));
            this.accepted = true;
            this.open = false;
        }
    }));
})

// Aguarda o DOM carregar para verificar se o Livewire subiu
document.addEventListener('DOMContentLoaded', () => {
    if (!window.Alpine) {
        import('alpinejs').then(({ default: Alpine }) => {
            window.Alpine = Alpine
            Alpine.start()
        })
    }
})



