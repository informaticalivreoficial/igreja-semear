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
            window.addEventListener('open-cookie-modal', () => {
                this.open = true;
            });

            let saved = null;
            try {
                saved = localStorage.getItem('cookie_consent');
            } catch (e) {
                saved = null;
            }

            if (saved) {
                try {
                    const prefs = JSON.parse(saved);
                    this.stats = prefs.stats ?? false;
                    this.marketing = prefs.marketing ?? false;
                    this.accepted = true;
                } catch (e) {
                    // prefêrencias inválidas: mantém o banner visível
                }
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

// Carrega o Alpine apenas se o Livewire ainda não o tiver disponibilizado.
// O Livewire 3 já embute e inicia o Alpine; este fallback cobre páginas sem ele,
// tentando de novo após o livewire:init (evita corrida com o DOMContentLoaded).
const loadAlpineFallback = () => {
    if (window.Alpine) {
        return;
    }

    import('alpinejs').then(({ default: Alpine }) => {
        if (window.Alpine) {
            return;
        }

        window.Alpine = Alpine;
        Alpine.start();
    });
};

document.addEventListener('DOMContentLoaded', loadAlpineFallback);
window.addEventListener('livewire:init', loadAlpineFallback);
setTimeout(loadAlpineFallback, 2500);



