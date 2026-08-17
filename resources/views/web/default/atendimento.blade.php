@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-14">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Atendimento</span>
            </nav>
            <h1 class="font-display mt-3 text-3xl font-bold text-white sm:text-4xl">Atendimento</h1>
            <p class="mt-3 max-w-2xl text-sky-100/90">Nossa equipe está pronta para melhor atender as suas demandas!</p>
        </div>
    </section>

    <section class="bg-brand-50 py-16">
        <div class="container-site grid gap-10 lg:grid-cols-5">
            <div class="lg:col-span-3">
                <div class="overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-sm">
                    <div class="border-b border-brand-100 p-6 sm:p-8">
                        <h2 class="font-display text-lg font-bold text-brand-900">Envie sua mensagem</h2>
                        <p class="mt-1 text-sm text-slate-500">Preencha o formulário abaixo e entraremos em contato.</p>
                    </div>

                    <form method="post" action="" id="form-atendimento" class="p-6 sm:p-8" novalidate autocomplete="off">
                        @csrf

                        <input type="hidden" name="bairro" value="">
                        <input type="hidden" name="cidade" value="">

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="input_name" class="mb-1.5 block text-sm font-semibold text-brand-800">Seu Nome <span class="text-red-500">*</span></label>
                                <input type="text" id="input_name" name="nome" class="input-site" placeholder="Nome completo">
                                <span class="field-error"></span>
                            </div>
                            <div>
                                <label for="input_email" class="mb-1.5 block text-sm font-semibold text-brand-800">E-mail <span class="text-red-500">*</span></label>
                                <input type="email" id="input_email" name="email" class="input-site" placeholder="Seu melhor e-mail">
                                <span class="field-error"></span>
                            </div>
                        </div>

                        <div class="mt-5">
                            <label for="input_phone" class="mb-1.5 block text-sm font-semibold text-brand-800">Telefone / WhatsApp</label>
                            <input
                                type="text"
                                id="input_phone"
                                name="phone"
                                x-data
                                x-init="if (window.IMask && !$el._imask) { $el._imask = IMask($el, { mask: '(00) 00000-0000' }); }"
                                class="input-site"
                                placeholder="(00) 00000-0000"
                                inputmode="tel"
                            >
                            <span class="field-error"></span>
                        </div>

                        <div class="mt-5">
                            <label for="textarea_message" class="mb-1.5 block text-sm font-semibold text-brand-800">Mensagem <span class="text-red-500">*</span></label>
                            <textarea id="textarea_message" name="mensagem" rows="5" class="input-site resize-none" placeholder="Digite sua mensagem"></textarea>
                            <span class="field-error"></span>
                        </div>

                        <label class="mt-5 flex items-start gap-3 text-sm text-slate-600">
                            <input type="checkbox" name="privacy" value="1" class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                            <span>
                                Autorizo a {{ optional($configuracoes)->app_name ?: 'Semear' }} a utilizar os meus dados
                                para responder esta solicitação. Li e aceito a
                                <a href="{{ route('web.politica') }}" target="_blank" rel="noopener" class="font-semibold text-brand-600 underline hover:text-brand-700">Política de Privacidade</a>.
                            </span>
                        </label>
                        <span class="field-error"></span>

                        <button type="submit" id="btn-enviar" class="btn-primary mt-6 inline-flex w-full items-center justify-center gap-2 px-8 py-3 text-base sm:w-auto">
                            <i class="fas fa-paper-plane"></i><span>Enviar Agora</span>
                        </button>
                    </form>
                </div>
            </div>

            @if($configuracoes)
                <div class="space-y-5 lg:col-span-2">
                    <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-700"><i class="fas fa-map-marker-alt"></i></span>
                            <h3 class="font-display text-lg font-bold text-brand-900">Endereço</h3>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            {{ trim(implode(', ', array_filter([$configuracoes->street, $configuracoes->number, $configuracoes->neighborhood, $configuracoes->city, $configuracoes->state]))) ?: 'Informação não preenchida.' }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-accent-500/15 text-accent-700"><i class="fas fa-phone-alt"></i></span>
                            <h3 class="font-display text-lg font-bold text-brand-900">Telefones</h3>
                        </div>
                        <div class="mt-3 space-y-2 text-sm text-slate-600">
                            @if($configuracoes->phone || $configuracoes->cell_phone)
                                <p><a href="tel:{{ $configuracoes->cell_phone ?: $configuracoes->phone }}" class="text-brand-600 hover:text-brand-700"><i class="fas fa-phone mr-1"></i>{{ $configuracoes->cell_phone ?: $configuracoes->phone }}</a></p>
                            @endif
                            @if($configuracoes->whatsapp)
                                <p><a href="https://wa.me/{{ preg_replace('/\D/', '', $configuracoes->whatsapp) }}" target="_blank" rel="noopener noreferrer" class="text-brand-600 hover:text-brand-700"><i class="fab fa-whatsapp mr-1"></i>{{ $configuracoes->whatsapp }}</a></p>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100 text-sky-700"><i class="fas fa-envelope"></i></span>
                            <h3 class="font-display text-lg font-bold text-brand-900">E-mail</h3>
                        </div>
                        <div class="mt-3 space-y-1 text-sm">
                            @if($configuracoes->email)
                                <p><a href="mailto:{{ $configuracoes->email }}" class="text-brand-600 hover:text-brand-700">{{ $configuracoes->email }}</a></p>
                            @endif
                            @if($configuracoes->additional_email)
                                <p><a href="mailto:{{ $configuracoes->additional_email }}" class="text-brand-600 hover:text-brand-700">{{ $configuracoes->additional_email }}</a></p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('js')
    <style>
        .field-error {
            display: none;
            margin-top: 0.35rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #dc2626;
        }

        .field-error.show {
            display: block;
        }

        .input-site.is-invalid {
            border-color: #dc2626;
            background-color: #fef2f2;
        }

        .input-site.is-invalid:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 2px rgb(220 38 38 / 0.15);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.getElementById('form-atendimento');
            var submitBtn = document.getElementById('btn-enviar');

            function findErrorSlot(input) {
                var node = input;

                for (var i = 0; i < 5; i++) {
                    if (!node.parentElement) break;
                    node = node.parentElement;
                    var slot = node.querySelector('.field-error');
                    if (slot) return slot;
                }

                return null;
            }

            function setError(name, message) {
                var input = form.querySelector('[name="' + name + '"]');
                if (!input) return;

                var slot = findErrorSlot(input);

                if (slot) {
                    slot.textContent = message;
                    slot.classList.add('show');
                }

                if (!input.classList.contains('peer')) {
                    input.classList.add('is-invalid');
                }
            }

            function clearErrors() {
                form.querySelectorAll('.field-error').forEach(function (slot) { slot.textContent = ''; slot.classList.remove('show'); });
                form.querySelectorAll('.is-invalid').forEach(function (el) { el.classList.remove('is-invalid'); });
            }

            form.querySelectorAll('input, textarea').forEach(function (el) {
                el.addEventListener('input', function () {
                    var slot = findErrorSlot(el);
                    if (slot) { slot.textContent = ''; slot.classList.remove('show'); }
                    el.classList.remove('is-invalid');
                });
            });

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                clearErrors();

                var data = new FormData(form);
                var val = function (name) { return (data.get(name) || '').toString().trim(); };
                var errors = [];

                if (val('nome').length < 3) {
                    errors.push(['nome', 'Informe o nome completo.']);
                }

                var email = val('email');
                if (!email) {
                    errors.push(['email', 'Informe o e-mail.']);
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    errors.push(['email', 'Informe um e-mail válido.']);
                }

                var phone = val('phone');
                if (phone && !/^\(\d{2}\)\s?\d{4,5}-\d{4}$/.test(phone)) {
                    errors.push(['phone', 'Informe um telefone válido: (00) 00000-0000.']);
                }

                if (val('mensagem').length < 10) {
                    errors.push(['mensagem', 'Escreva uma mensagem com pelo menos 10 caracteres.']);
                }

                if (!data.get('privacy')) {
                    errors.push(['privacy', 'É necessário concordar com a Política de Privacidade.']);
                }

                if (errors.length) {
                    errors.forEach(function (err) { setError(err[0], err[1]); });

                    if (window.Toastify) {
                        Toastify({ text: 'Verifique os campos destacados e tente novamente.', style: { background: '#dc2626' }, gravity: 'top', position: 'center' }).showToast();
                    }

                    var first = form.querySelector('.is-invalid');
                    if (first) { first.focus(); }

                    return;
                }

                submitBtn.disabled = true;
                submitBtn.querySelector('i').className = 'fas fa-spinner fa-spin';
                submitBtn.querySelector('span').textContent = ' Enviando...';

                var params = new URLSearchParams(new FormData(form));

                fetch('{{ route('web.sendEmail') }}?' + params.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(function (r) { return r.json(); })
                    .then(function (res) {
                        if (res.error) {
                            if (window.Toastify) {
                                Toastify({ text: res.error.replace(/<[^>]+>/g, ''), style: { background: '#dc2626' }, gravity: 'top', position: 'center' }).showToast();
                            }
                        } else if (window.Swal) {
                            Swal.fire({
                                title: 'Mensagem enviada!',
                                html: '<p>' + (res.sucess || 'Sua mensagem foi enviada com sucesso!') + '</p>',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#076134',
                                allowOutsideClick: false
                            });
                            form.reset();
                        }
                    })
                    .catch(function () {
                        if (window.Toastify) {
                            Toastify({ text: 'Ocorreu um erro ao enviar. Tente novamente.', style: { background: '#dc2626' }, gravity: 'top', position: 'center' }).showToast();
                        }
                    })
                    .finally(function () {
                        submitBtn.disabled = false;
                        submitBtn.querySelector('i').className = 'fas fa-paper-plane';
                        submitBtn.querySelector('span').textContent = ' Enviar Agora';
                    });
            });
        });
    </script>
@endpush