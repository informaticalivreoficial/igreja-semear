<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', env('APP_NAME')) | {{ env('APP_NAME') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

    {{-- Tom Select --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

    {{-- Toastify --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    {{-- basicLightbox --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/basiclightbox@5/dist/basicLightbox.min.css">

    {{-- Quill --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        .basicLightbox {
            z-index: 9999 !important;
        }

        .basicLightbox__placeholder {
            z-index: 9999 !important;
        }

        .ql-editor {
            min-height: 180px;
            max-height: 350px;
            overflow-y: auto;
        }
    </style>

    @stack('styles')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-paper min-h-screen text-slate-800 antialiased">
    <div x-data="appShell()" class="min-h-screen">

        {{-- Sidebar Desktop + Drawer Mobile --}}
        <livewire:navigation.side-navigation />

        {{-- Overlay (mobile) --}}
        <div x-show="mobileOpen" x-transition-opacity
             @click="mobileOpen = false"
             class="fixed inset-0 z-30 bg-forest-900/60 backdrop-blur-sm lg:hidden"
             style="display:none;"></div>

        {{-- Conteúdo Principal --}}
        <div class="flex min-h-screen flex-col transition-[padding-left] duration-300 lg:pl-60"
             :class="collapsed ? 'lg:!pl-20' : 'lg:pl-60'">

            {{-- Topbar --}}
            <livewire:navigation.top-navigation />

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>

            <livewire:navigation.footer />
        </div>
    </div>

    @auth
        <livewire:components.support-modal />
        <livewire:components.toastr-notification />
    @endauth

    {{-- Tom Select --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/basiclightbox@5/dist/basicLightbox.min.js"></script>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://unpkg.com/quill-image-resize-module/image-resize.min.js"></script>

    <script>
        if (typeof ImageResize !== 'undefined') {
            Quill.register('modules/imageResize', ImageResize.default, true);
        }
    </script>

    @stack('scripts')

    <script>
        function appShell() {
            return {
                collapsed: false,
                mobileOpen: false,

                toggleSidebar() {
                    if (window.innerWidth < 1024) {
                        this.mobileOpen = !this.mobileOpen;
                    } else {
                        this.collapsed = !this.collapsed;
                    }
                },

                closeMobile() {
                    this.mobileOpen = false;
                },

                toggleFullscreen() {
                    if (!document.fullscreenElement) {
                        document.documentElement.requestFullscreen();
                    } else {
                        document.exitFullscreen();
                    }
                },
            };
        }

        // Listener genérico para todos os tipos de SweetAlert
        ['swal', 'swal:error', 'swal:success', 'swal:info', 'swal:warning'].forEach(eventName => {
            window.addEventListener(eventName, (event) => {
                const data = event.detail?.[0] ?? {};

                let defaultIcon = 'info';
                if (eventName === 'swal:error') defaultIcon = 'error';
                if (eventName === 'swal:success') defaultIcon = 'success';
                if (eventName === 'swal:warning') defaultIcon = 'warning';

                Swal.fire({
                    title: data.title ?? 'Aviso',
                    text: data.text ?? '',
                    icon: data.icon ?? defaultIcon,
                    timer: data.timer ?? null,
                    showConfirmButton: data.showConfirmButton ?? true,
                    confirmButtonText: data.confirmButtonText ?? 'OK',
                }).then((result) => {
                    if (data.redirectUrl) {
                        window.location.href = data.redirectUrl;
                    }
                });
            });
        });

        // Listener para confirmação (precisa de lógica especial)
        window.addEventListener('swal:confirm', (event) => {
            const data = event.detail?.[0] ?? {};

            Swal.fire({
                title: data.title ?? 'Tem certeza?',
                text: data.text ?? '',
                icon: data.icon ?? 'warning',
                showCancelButton: true,
                confirmButtonText: data.confirmButtonText ?? 'Confirmar',
                cancelButtonText: data.cancelButtonText ?? 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed && data.confirmEvent) {
                    Livewire.dispatch(data.confirmEvent, data.confirmParams ?? []);
                }
            });
        });

        document.addEventListener('alpine:init', () => {
            Alpine.data('quillEditor', ({ value, model }) => ({
                quill: null,

                init() {
                    if (this.quill) return;

                    this.quill = new Quill(this.$refs.editor, {
                        theme: 'snow',
                        placeholder: 'Digite aqui...',
                        modules: {
                            toolbar: [
                                [{ header: [1, 2, 3, false] }],
                                [{ font: [] }, { size: ['small', false, 'large', 'huge'] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{ color: [] }, { background: [] }],
                                [{ align: [] }],
                                [{ list: 'ordered' }, { list: 'bullet' }],
                                ['blockquote'],
                                ['link', 'image'],
                                ['clean'],
                            ],
                            imageResize: {
                                displaySize: true,
                                modules: ['Resize', 'DisplaySize']
                            }
                        },
                    });

                    const editorEl = this.$refs.editor.querySelector('.ql-editor');
                    editorEl.style.maxHeight = '350px';
                    editorEl.style.overflowY = 'auto';

                    if (value) {
                        this.quill.root.innerHTML = value;
                    }

                    this.sync();

                    this.quill.on('text-change', () => {
                        this.sync();
                    });

                    this.addImageAlignmentSupport();
                },

                sync() {
                    const html = this.quill.root.innerHTML;
                    const componentEl = this.$el.closest('[wire\\:id]');

                    if (!componentEl || typeof Livewire === 'undefined') return;

                    const component = Livewire.find(componentEl.getAttribute('wire:id'));
                    if (component) {
                        component.set(model, html, false);
                    }
                },

                addImageAlignmentSupport() {
                    this.quill.root.addEventListener('click', (e) => {
                        if (e.target.tagName === 'IMG') {
                            const parent = e.target.closest('p');
                            if (parent) {
                                const alignment = parent.className.match(/ql-align-(\w+)/);
                                if (alignment) {
                                    this.applyImageAlignment(e.target, alignment[1]);
                                }
                            }
                        }
                    });

                    const observer = new MutationObserver((mutations) => {
                        mutations.forEach((mutation) => {
                            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                                const target = mutation.target;
                                const img = target.querySelector('img');
                                if (img) {
                                    const alignment = target.className.match(/ql-align-(\w+)/);
                                    if (alignment) {
                                        this.applyImageAlignment(img, alignment[1]);
                                    }
                                }
                            }
                        });
                    });

                    observer.observe(this.quill.root, {
                        attributes: true,
                        attributeFilter: ['class'],
                        subtree: true
                    });
                },

                applyImageAlignment(img, alignment) {
                    img.style.marginLeft = '';
                    img.style.marginRight = '';
                    img.style.display = 'block';

                    switch (alignment) {
                        case 'center':
                            img.style.marginLeft = 'auto';
                            img.style.marginRight = 'auto';
                            break;
                        case 'right':
                            img.style.marginLeft = 'auto';
                            img.style.marginRight = '0';
                            break;
                        case 'left':
                            img.style.marginLeft = '0';
                            img.style.marginRight = 'auto';
                            break;
                    }

                    this.sync();
                },
            }));
        });        
    </script>
</body>
</html>
