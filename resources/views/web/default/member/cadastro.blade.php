@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-14">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Cadastro de Membros</span>
            </nav>
            <h1 class="font-display mt-3 text-3xl font-bold text-white sm:text-4xl">Cadastro de Membros</h1>
            <p class="mt-3 max-w-2xl text-sky-100/90">Preencha o formulário abaixo para fazer parte da nossa comunidade.</p>
        </div>
    </section>

    <section class="bg-slate-50 py-16">
        <div class="container-site max-w-4xl">
            <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                <form
                    method="post"
                    action=""
                    id="form-membro"
                    novalidate
                    x-data="{ baptism: '', whatsapp_group: '', ministerio_group: '', ministerio_accept: '' }"
                    autocomplete="off"
                >
                    @csrf
                    <input type="hidden" name="bairro" value="">
                    <input type="hidden" name="cidade" value="">

                    {{-- DADOS PESSOAIS --}}
                    <div class="border-b border-slate-100 p-6 sm:p-8">
                        <div class="mb-6 flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-600 text-sm font-bold text-white">1</span>
                            <div>
                                <h2 class="font-display text-lg font-bold text-slate-900">Dados Pessoais</h2>
                                <p class="text-sm text-slate-500">Quem está se cadastrando.</p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-800">Nome Completo <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" class="input-site" placeholder="Nome Completo">
                                <span class="field-error"></span>
                            </div>
                            <div>
                                <label for="birthday" class="mb-1.5 block text-sm font-semibold text-slate-800">Data de Nascimento <span class="text-red-500">*</span></label>
                                <input type="text" name="birthday" id="birthday" class="input-site" placeholder="dd/mm/aaaa" inputmode="numeric">
                                <span class="field-error"></span>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-800">Sexo <span class="text-red-500">*</span></label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="gender" value="masculino" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300"><i class="fas fa-mars"></i> Masculino</span>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="gender" value="feminino" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300"><i class="fas fa-venus"></i> Feminino</span>
                                    </label>
                                </div>
                                <span class="field-error"></span>
                            </div>
                            <div>
                                <label for="civil_status" class="mb-1.5 block text-sm font-semibold text-slate-800">Estado Civil</label>
                                <select name="civil_status" id="civil_status" class="input-site">
                                    <option value="solteiro">Solteiro(a)</option>
                                    <option value="casado">Casado(a)</option>
                                    <option value="separado">Separado(a)</option>
                                    <option value="divorciado">Divorciado(a)</option>
                                    <option value="viuvo">Viúvo(a)</option>
                                </select>
                            </div>
                            <div>
                                <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-800">E-mail <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" class="input-site" placeholder="Digite aqui seu melhor e-mail">
                                <span class="field-error"></span>
                            </div>
                            <div>
                                <label for="whatsapp" class="mb-1.5 block text-sm font-semibold text-slate-800">Celular / WhatsApp <span class="text-red-500">*</span></label>
                                <input type="text" name="whatsapp" id="whatsapp" class="input-site" placeholder="(00) 00000-0000" inputmode="tel">
                                <span class="field-error"></span>
                            </div>
                        </div>
                    </div>

                    {{-- ENDEREÇO --}}
                    <div class="border-b border-slate-100 p-6 sm:p-8">
                        <div class="mb-6 flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-accent-500 text-sm font-bold text-white">2</span>
                            <div>
                                <h2 class="font-display text-lg font-bold text-slate-900">Endereço</h2>
                                <p class="text-sm text-slate-500">Opcional, mas ajuda a igreja a te encontrar.</p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-6">
                            <div class="sm:col-span-1">
                                <label for="cep" class="mb-1.5 block text-sm font-semibold text-slate-800">CEP</label>
                                <input type="text" name="postcode" id="cep" class="input-site" placeholder="00000-000" inputmode="numeric">
                                <span class="field-error"></span>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="rua" class="mb-1.5 block text-sm font-semibold text-slate-800">Rua</label>
                                <input type="text" name="street" id="rua" class="input-site">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="bairro" class="mb-1.5 block text-sm font-semibold text-slate-800">Bairro</label>
                                <input type="text" name="neighborhood" id="bairro" class="input-site">
                            </div>
                            <div class="sm:col-span-1">
                                <label for="uf" class="mb-1.5 block text-sm font-semibold text-slate-800">UF</label>
                                <input type="text" name="state" id="uf" class="input-site" maxlength="2" placeholder="SP">
                            </div>
                            <div class="sm:col-span-3">
                                <label for="cidade" class="mb-1.5 block text-sm font-semibold text-slate-800">Cidade</label>
                                <input type="text" name="city" id="cidade" class="input-site">
                            </div>
                            <div class="sm:col-span-1">
                                <label for="number" class="mb-1.5 block text-sm font-semibold text-slate-800">Número</label>
                                <input type="text" name="number" id="number" class="input-site">
                            </div>
                            <div class="sm:col-span-1">
                                <label for="complement" class="mb-1.5 block text-sm font-semibold text-slate-800">Complemento</label>
                                <input type="text" name="complement" id="complement" class="input-site">
                            </div>
                        </div>
                    </div>

                    {{-- BATISMO --}}
                    <div class="border-b border-slate-100 p-6 sm:p-8">
                        <div class="mb-6 flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-sky-500 text-sm font-bold text-white">3</span>
                            <div>
                                <h2 class="font-display text-lg font-bold text-slate-900">Batismo</h2>
                                <p class="text-sm text-slate-500">Sua caminhada com Deus importa para nós.</p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-800">É batizado(a)? <span class="text-red-500">*</span></label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" x-model="baptism" name="baptism" value="true" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Sim</span>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" x-model="baptism" name="baptism" value="false" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Não</span>
                                    </label>
                                </div>
                                <span class="field-error"></span>
                            </div>
                            <div x-show="baptism === 'true'" x-cloak>
                                <label for="baptism_date" class="mb-1.5 block text-sm font-semibold text-slate-800">Data do Batismo</label>
                                <input type="text" name="baptism_date" id="baptism_date" class="input-site" placeholder="dd/mm/aaaa" inputmode="numeric">
                                <span class="field-error"></span>
                            </div>
                            <div x-show="baptism === 'false'" x-cloak class="sm:col-span-2">
                                <label class="mb-1.5 block text-sm font-semibold text-slate-800">Deseja se batizar?</label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="baptism_option" value="true" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Sim</span>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="baptism_option" value="false" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Não</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PARTICIPAÇÃO --}}
                    <div class="border-b border-slate-100 p-6 sm:p-8">
                        <div class="mb-6 flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-600 text-sm font-bold text-white">4</span>
                            <div>
                                <h2 class="font-display text-lg font-bold text-slate-900">Participação</h2>
                                <p class="text-sm text-slate-500">Conte para a gente como você quer se envolver.</p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="period_frequenci" class="mb-1.5 block text-sm font-semibold text-slate-800">Há quanto tempo frequenta a Semear?</label>
                                <input type="text" name="period_frequenci" id="period_frequenci" class="input-site" placeholder="Ex.: 6 meses, 1 ano...">
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-800">Participa dos grupos de WhatsApp da igreja?</label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" x-model="whatsapp_group" name="whatsapp_group" value="true" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Sim</span>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" x-model="whatsapp_group" name="whatsapp_group" value="false" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Não</span>
                                    </label>
                                </div>
                            </div>
                            <div x-show="whatsapp_group === 'false'" x-cloak class="sm:col-span-2">
                                <label class="mb-1.5 block text-sm font-semibold text-slate-800">Gostaria de participar?</label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="whatsapp_group_accept" value="true" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Sim</span>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="whatsapp_group_accept" value="false" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Não</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-800">Participa de algum ministério da igreja?</label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" x-model="ministerio_group" name="ministerio_group" value="true" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Sim</span>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" x-model="ministerio_group" name="ministerio_group" value="false" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Não</span>
                                    </label>
                                </div>
                            </div>
                            <div x-show="ministerio_group === 'true'" x-cloak>
                                <label for="ministerio_name" class="mb-1.5 block text-sm font-semibold text-slate-800">Qual?</label>
                                <input type="text" name="ministerio_name" id="ministerio_name" class="input-site" placeholder="Ex.: Louvor, Intercessão...">
                            </div>
                            <div x-show="ministerio_group === 'false'" x-cloak class="sm:col-span-2">
                                <label class="mb-1.5 block text-sm font-semibold text-slate-800">Gostaria de participar de algum ministério?</label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" x-model="ministerio_accept" name="ministerio_accept" value="true" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Sim</span>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" x-model="ministerio_accept" name="ministerio_accept" value="false" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Não</span>
                                    </label>
                                </div>
                                <div x-show="ministerio_accept === 'true'" x-cloak class="mt-4">
                                    <label for="ministerio_accept_name" class="mb-1.5 block text-sm font-semibold text-slate-800">Qual?</label>
                                    <input type="text" name="ministerio_accept_name" id="ministerio_accept_name" class="input-site" placeholder="Ex.: Louvor, Intercessão...">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- VISITA --}}
                    <div class="p-6 sm:p-8">
                        <div class="mb-6 flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-accent-500 text-sm font-bold text-white">5</span>
                            <div>
                                <h2 class="font-display text-lg font-bold text-slate-900">Conhecer a Igreja</h2>
                                <p class="text-sm text-slate-500">Gostaríamos muito de te receber.</p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-800">Gostaria de agendar um horário na igreja para nos conhecer melhor?</label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="hour_accept" value="true" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Sim</span>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="hour_accept" value="false" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Não</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-800">Podemos entrar em contato para agendar?</label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="hour_accept_agend" value="true" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Sim</span>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="hour_accept_agend" value="false" class="peer sr-only">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition peer-checked:border-brand-600 peer-checked:bg-brand-50 peer-checked:text-brand-700 hover:border-brand-300">Não</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 bg-slate-50/60 p-6 sm:p-8">
                        <div class="flex flex-col items-center gap-4 sm:flex-row sm:justify-between">
                            <p class="max-w-md text-xs text-slate-500">
                                Ao clicar em cadastrar, você confirma e aceita os
                                <a href="{{ route('web.politica') }}" target="_blank" rel="noopener" class="font-semibold text-brand-600 underline hover:text-brand-700">Termos de uso e Política de Privacidade</a>.
                            </p>
                            <button type="submit" id="btn-cadastrar" class="btn-primary inline-flex w-full items-center justify-center gap-2 px-8 py-3 text-base sm:w-auto">
                                <i class="fas fa-user-plus"></i><span>Cadastrar Agora</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
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
            var form = document.getElementById('form-membro');
            var submitBtn = document.getElementById('btn-cadastrar');

            if (window.flatpickr) {
                flatpickr('#birthday', { dateFormat: 'd/m/Y', maxDate: 'today', locale: FlatpickrPortuguese, disableMobile: true });
                flatpickr('#baptism_date', { dateFormat: 'd/m/Y', maxDate: 'today', locale: FlatpickrPortuguese, disableMobile: true });
            }

            if (window.IMask) {
                IMask(document.getElementById('whatsapp'), { mask: '(00) 00000-0000' });
                IMask(document.getElementById('cep'), { mask: '00000-000' });
            }

            var cepInput = document.getElementById('cep');
            var loadingFields = ['rua', 'bairro', 'cidade', 'uf'];

            function limpaCep() {
                loadingFields.forEach(function (id) { document.getElementById(id).value = ''; });
            }

            if (cepInput) {
                cepInput.addEventListener('change', function () {
                    var cep = this.value.replace(/\D/g, '');
                    if (cep.length !== 8) { limpaCep(); return; }

                    loadingFields.forEach(function (id) { document.getElementById(id).value = 'Carregando...'; });

                    fetch('https://viacep.com.br/ws/' + cep + '/json/')
                        .then(function (r) { return r.json(); })
                        .then(function (dados) {
                            if (!dados.erro) {
                                document.getElementById('rua').value = dados.logradouro || '';
                                document.getElementById('bairro').value = dados.bairro || '';
                                document.getElementById('cidade').value = dados.localidade || '';
                                document.getElementById('uf').value = dados.uf || '';
                            } else {
                                limpaCep();
                                if (window.Toastify) {
                                    Toastify({ text: 'CEP não encontrado.', style: { background: '#dc2626' }, gravity: 'top', position: 'center' }).showToast();
                                }
                            }
                        })
                        .catch(limpaCep);
                });
            }

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

            form.querySelectorAll('input, select, textarea').forEach(function (el) {
                el.addEventListener('input', function () {
                    var slot = findErrorSlot(el);
                    if (slot) { slot.textContent = ''; slot.classList.remove('show'); }
                    el.classList.remove('is-invalid');
                });
            });

            function validateForm() {
                var errors = [];
                var data = new FormData(form);
                var val = function (name) { return (data.get(name) || '').toString().trim(); };

                if (val('name').length < 3) {
                    errors.push(['name', 'Informe o nome completo.']);
                }

                var birthday = val('birthday');
                if (!/^\d{2}\/\d{2}\/\d{4}$/.test(birthday)) {
                    errors.push(['birthday', 'Informe a data de nascimento (dd/mm/aaaa).']);
                } else {
                    var parts = birthday.split('/');
                    var d = new Date(parts[2], parts[1] - 1, parts[0]);
                    if (d.getDate() !== parseInt(parts[0], 10) || d.getMonth() !== (parseInt(parts[1], 10) - 1)) {
                        errors.push(['birthday', 'Data de nascimento inválida.']);
                    } else if (d.getTime() > Date.now()) {
                        errors.push(['birthday', 'A data de nascimento não pode ser no futuro.']);
                    }
                }

                if (!data.get('gender')) {
                    errors.push(['gender', 'Informe o sexo.']);
                }

                var email = val('email');
                if (!email) {
                    errors.push(['email', 'Informe o e-mail.']);
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    errors.push(['email', 'Informe um e-mail válido.']);
                }

                if (val('whatsapp').replace(/\D/g, '').length < 10) {
                    errors.push(['whatsapp', 'Informe um celular/WhatsApp válido.']);
                }

                if (!data.get('baptism')) {
                    errors.push(['baptism', 'Informe se é batizado(a).']);
                } else if (data.get('baptism') === 'true') {
                    var bd = val('baptism_date');
                    if (!/^\d{2}\/\d{2}\/\d{4}$/.test(bd)) {
                        errors.push(['baptism_date', 'Informe a data do batismo.']);
                    }
                }

                return errors;
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                clearErrors();

                var errors = validateForm();

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

                fetch('{{ route('web.create.member.send') }}?' + params.toString(), {
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
                                title: 'Cadastro realizado!',
                                html: '<p>Obrigado, <strong>' + res.name + '</strong>!</p><p>' + res.cadastro + '</p>',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#076134',
                                allowOutsideClick: false
                            }).then(function (result) {
                                if (result.isConfirmed) { window.location.href = '{{ route('web.home') }}'; }
                            });
                        }
                    })
                    .catch(function () {
                        if (window.Toastify) {
                            Toastify({ text: 'Ocorreu um erro ao cadastrar. Tente novamente.', style: { background: '#dc2626' }, gravity: 'top', position: 'center' }).showToast();
                        }
                    })
                    .finally(function () {
                        submitBtn.disabled = false;
                        submitBtn.querySelector('i').className = 'fas fa-user-plus';
                        submitBtn.querySelector('span').textContent = ' Cadastrar Agora';
                    });
            });
        });
    </script>
@endpush
