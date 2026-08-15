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
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-10">
                <form
                    method="post"
                    action=""
                    id="form-membro"
                    x-data="{ baptism: '', whatsapp_group: '', ministerio_group: '', ministerio_accept: '' }"
                    autocomplete="off"
                >
                    @csrf
                    <input type="hidden" name="bairro" value="">
                    <input type="hidden" name="cidade" value="">

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Nome Completo *</label>
                            <input type="text" name="name" class="input-site" placeholder="Nome Completo" required>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Data de Nascimento *</label>
                            <input type="text" name="birthday" id="birthday" class="input-site" placeholder="dd/mm/aaaa" required>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Sexo *</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" name="gender" value="masculino" required class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Masculino
                                </label>
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" name="gender" value="feminino" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Feminino
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Estado Civil</label>
                            <select name="civil_status" class="input-site">
                                <option value="solteiro">Solteiro(a)</option>
                                <option value="casado">Casado(a)</option>
                                <option value="separado">Separado(a)</option>
                                <option value="divorciado">Divorciado(a)</option>
                                <option value="viuvo">Viúvo(a)</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">E-mail *</label>
                            <input type="email" name="email" class="input-site" placeholder="Digite aqui seu melhor e-mail" required>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Celular / WhatsApp *</label>
                            <input type="text" name="whatsapp" id="whatsapp" class="input-site" placeholder="(00) 00000-0000" required>
                        </div>
                    </div>

                    <hr class="my-8 border-slate-100">

                    <h2 class="font-display text-lg font-bold text-slate-900">Endereço</h2>
                    <div class="mt-5 grid gap-5 sm:grid-cols-6">
                        <div class="sm:col-span-1">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">CEP</label>
                            <input type="text" name="postcode" id="cep" class="input-site" placeholder="00000-000">
                        </div>
                        <div class="sm:col-span-3">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Rua</label>
                            <input type="text" name="street" id="rua" class="input-site">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Bairro</label>
                            <input type="text" name="neighborhood" id="bairro" class="input-site">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">UF</label>
                            <input type="text" name="state" id="uf" class="input-site">
                        </div>
                        <div class="sm:col-span-3">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Cidade</label>
                            <input type="text" name="city" id="cidade" class="input-site">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Número</label>
                            <input type="text" name="number" class="input-site">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Complemento</label>
                            <input type="text" name="complement" class="input-site">
                        </div>
                    </div>

                    <hr class="my-8 border-slate-100">

                    <h2 class="font-display text-lg font-bold text-slate-900">Batismo</h2>
                    <div class="mt-5 grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">É batizado(a)? *</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" x-model="baptism" name="baptism" value="true" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Sim
                                </label>
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" x-model="baptism" name="baptism" value="false" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Não
                                </label>
                            </div>
                        </div>
                        <div x-show="baptism === 'true'" x-cloak>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Data do Batismo</label>
                            <input type="text" name="baptism_date" id="baptism" class="input-site" placeholder="dd/mm/aaaa">
                        </div>
                        <div x-show="baptism === 'false'" x-cloak class="sm:col-span-2">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Deseja se batizar?</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" name="baptism_option" value="true" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Sim
                                </label>
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" name="baptism_option" value="false" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Não
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-8 border-slate-100">

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Há quanto tempo frequenta a Semear?</label>
                            <input type="text" name="period_frequenci" class="input-site">
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Participa dos grupos de WhatsApp da igreja?</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" x-model="whatsapp_group" name="whatsapp_group" value="true" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Sim
                                </label>
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" x-model="whatsapp_group" name="whatsapp_group" value="false" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Não
                                </label>
                            </div>
                        </div>
                        <div x-show="whatsapp_group === 'false'" x-cloak class="sm:col-span-2">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Gostaria de participar?</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" name="whatsapp_group_accept" value="true" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Sim
                                </label>
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" name="whatsapp_group_accept" value="false" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Não
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-8 border-slate-100">

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Participa de algum ministério da igreja?</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" x-model="ministerio_group" name="ministerio_group" value="true" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Sim
                                </label>
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" x-model="ministerio_group" name="ministerio_group" value="false" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Não
                                </label>
                            </div>
                        </div>
                        <div x-show="ministerio_group === 'true'" x-cloak>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Qual?</label>
                            <input type="text" name="ministerio_name" class="input-site">
                        </div>
                        <div x-show="ministerio_group === 'false'" x-cloak class="sm:col-span-2">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Gostaria de participar de algum ministério?</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" x-model="ministerio_accept" name="ministerio_accept" value="true" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Sim
                                </label>
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" x-model="ministerio_accept" name="ministerio_accept" value="false" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Não
                                </label>
                            </div>
                            <div x-show="ministerio_accept === 'true'" x-cloak class="mt-4">
                                <label class="mb-1.5 block text-sm font-semibold text-slate-800">Qual?</label>
                                <input type="text" name="ministerio_accept_name" class="input-site">
                            </div>
                        </div>
                    </div>

                    <hr class="my-8 border-slate-100">

                    <div class="grid gap-5">
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Gostaria de agendar um horário na igreja para nos conhecer melhor?</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" name="hour_accept" value="true" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Sim
                                </label>
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" name="hour_accept" value="false" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Não
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-800">Podemos entrar em contato para agendar?</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" name="hour_accept_agend" value="true" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Sim
                                </label>
                                <label class="flex items-center gap-2 text-sm text-slate-700">
                                    <input type="radio" name="hour_accept_agend" value="false" class="h-4 w-4 border-slate-300 text-sky-600 focus:ring-sky-500"> Não
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <button type="submit" class="btn-primary w-full sm:w-auto">Cadastrar Agora</button>
                        <p class="mt-3 text-xs text-slate-500">
                            Ao clicar no botão de cadastrar, você confirma e aceita os Termos de uso e a
                            <a href="{{ route('web.politica') }}" class="text-sky-600 underline">Política de Privacidade</a>.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.flatpickr) {
                flatpickr('#birthday', { dateFormat: 'd/m/Y', maxDate: 'today', locale: FlatpickrPortuguese });
                flatpickr('#baptism', { dateFormat: 'd/m/Y', maxDate: 'today', locale: FlatpickrPortuguese });
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

            document.getElementById('form-membro').addEventListener('submit', function (e) {
                e.preventDefault();
                var form = this;
                var btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.textContent = 'Carregando...';

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
                                title: 'Obrigado ' + res.name,
                                text: res.cadastro,
                                icon: 'success',
                                confirmButtonText: 'OK'
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
                        btn.disabled = false;
                        btn.textContent = 'Cadastrar Agora';
                    });
            });
        });
    </script>
@endpush
