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

    <section class="bg-white py-16">
        <div class="container-site grid gap-10 lg:grid-cols-2">
            <div>
                <h2 class="section-title">Envie sua mensagem</h2>
                <form method="post" action="" id="form-atendimento" class="mt-8 space-y-5" autocomplete="off">
                    @csrf
                    <div id="js-contact-result"></div>

                    <input type="hidden" name="bairro" value="">
                    <input type="hidden" name="cidade" value="">

                    <div>
                        <label for="input_name" class="mb-1.5 block text-sm font-semibold text-slate-800">Seu Nome</label>
                        <input type="text" id="input_name" name="nome" class="input-site" placeholder="Seu Nome">
                    </div>
                    <div>
                        <label for="input_email" class="mb-1.5 block text-sm font-semibold text-slate-800">E-mail</label>
                        <input type="email" id="input_email" name="email" class="input-site" placeholder="E-mail">
                    </div>
                    <div>
                        <label for="textarea_message" class="mb-1.5 block text-sm font-semibold text-slate-800">Mensagem</label>
                        <textarea id="textarea_message" name="mensagem" rows="5" class="input-site resize-none" placeholder="Digite sua mensagem"></textarea>
                    </div>
                    <button type="submit" class="btn-primary">Enviar Agora</button>
                </form>
            </div>

            @if($configuracoes)
                <div class="space-y-5">
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6">
                        <h3 class="font-display text-lg font-bold text-slate-900">Endereço</h3>
                        <p class="mt-2 text-sm text-slate-600">
                            {{ trim(implode(', ', array_filter([$configuracoes->street, $configuracoes->number, $configuracoes->neighborhood, $configuracoes->city, $configuracoes->state]))) ?: 'Informação não preenchida.' }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6">
                        <h3 class="font-display text-lg font-bold text-slate-900">Telefones</h3>
                        <div class="mt-2 space-y-1 text-sm text-slate-600">
                            @if($configuracoes->phone || $configuracoes->cell_phone)
                                <p><a href="tel:{{ $configuracoes->cell_phone ?: $configuracoes->phone }}" class="text-sky-600 hover:text-sky-700">{{ $configuracoes->cell_phone ?: $configuracoes->phone }}</a></p>
                            @endif
                            @if($configuracoes->whatsapp)
                                <p>WhatsApp: <a href="https://wa.me/{{ preg_replace('/\D/', '', $configuracoes->whatsapp) }}" target="_blank" rel="noopener noreferrer" class="text-sky-600 hover:text-sky-700">{{ $configuracoes->whatsapp }}</a></p>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-6">
                        <h3 class="font-display text-lg font-bold text-slate-900">E-mail</h3>
                        <p class="mt-2 text-sm">
                            @if($configuracoes->email)
                                <a href="mailto:{{ $configuracoes->email }}" class="text-sky-600 hover:text-sky-700">{{ $configuracoes->email }}</a>
                            @endif
                            @if($configuracoes->additional_email)
                                <br><a href="mailto:{{ $configuracoes->additional_email }}" class="text-sky-600 hover:text-sky-700">{{ $configuracoes->additional_email }}</a>
                            @endif
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('js')
    <script>
        document.getElementById('form-atendimento').addEventListener('submit', function (e) {
            e.preventDefault();
            var form = this;
            var result = document.getElementById('js-contact-result');
            result.innerHTML = '';
            var btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.textContent = 'Carregando...';

            var params = new URLSearchParams(new FormData(form));

            fetch('{{ route('web.sendEmail') }}?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (res.error) {
                        result.innerHTML = '<div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">' + res.error + '</div>';
                    } else {
                        result.innerHTML = '<div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">' + (res.sucess || 'Mensagem enviada!') + '</div>';
                        form.reset();
                    }
                })
                .catch(function () {
                    result.innerHTML = '<div class="rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">Ocorreu um erro ao enviar. Tente novamente.</div>';
                })
                .finally(function () {
                    btn.disabled = false;
                    btn.textContent = 'Enviar Agora';
                });
        });
    </script>
@endpush
