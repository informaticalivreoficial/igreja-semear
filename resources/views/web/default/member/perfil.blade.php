@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="page-hero py-12">
        <div class="container-site">
            <nav class="breadcrumb-site" aria-label="breadcrumb">
                <a href="{{ route('web.home') }}">Início</a>
                <span class="sep">/</span>
                <span>Meu perfil</span>
            </nav>
            <h1 class="font-display mt-3 text-2xl font-bold text-white sm:text-3xl">Meu perfil</h1>
            <p class="mt-2 max-w-2xl text-sky-100/90">Mantenha suas informações atualizadas.</p>
        </div>
    </section>

    <section class="bg-brand-50 py-12">
        <div class="container-site flex flex-col gap-8 lg:flex-row">
            @include('web.'.$configuracoes->template.'.member.sidebar')

            <div class="min-w-0 flex-1">
                @if ($errors->any())
                    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 p-4">
                        <ul class="list-inside list-disc text-sm text-rose-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('member.perfil.update') }}" enctype="multipart/form-data" class="rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
                    @csrf

                    <h2 class="font-display text-lg font-bold text-brand-900">Foto do perfil</h2>
                    <div class="mt-4 flex items-center gap-5">
                        <div class="relative">
                            @if($member->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($member->avatar))
                                <img id="avatar-preview" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($member->avatar) }}" alt="Foto do perfil" class="h-20 w-20 rounded-full object-cover ring-2 ring-brand-200">
                            @else
                                <div id="avatar-preview" class="flex h-20 w-20 items-center justify-center rounded-full bg-brand-600 text-2xl font-bold text-white ring-2 ring-brand-200">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <label for="foto" class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-brand-50 px-4 py-2 text-sm font-semibold text-brand-700 transition hover:bg-brand-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Alterar foto
                            </label>
                            <input type="file" id="foto" name="foto" accept="image/jpeg,image/jpg,image/png,image/webp" class="hidden">
                            <p class="mt-1.5 text-xs text-slate-500">Formatos: JPG, PNG ou WebP · máx. 2MB</p>
                        </div>
                    </div>

                    <h2 class="font-display mt-8 text-lg font-bold text-brand-900">Dados pessoais</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-brand-700">Nome completo *</label>
                            <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-brand-700">E-mail *</label>
                            <input type="email" name="email" value="{{ old('email', $member->email ?? auth()->user()->email) }}" required class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-brand-700">Telefone / WhatsApp</label>
                            <input
                                type="text"
                                name="cell_phone"
                                value="{{ old('cell_phone', $member->cell_phone) }}"
                                x-data
                                x-init="if (window.IMask && !$el._imask) { $el._imask = IMask($el, { mask: '(00) 00000-0000' }); }"
                                class="form-control"
                                placeholder="(00) 00000-0000"
                                inputmode="tel"
                            >
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-brand-700">Data de nascimento</label>
                            <input
                                type="text"
                                name="birthday"
                                id="birthday"
                                value="{{ old('birthday', $member->birthday?->format('d/m/Y')) }}"
                                class="form-control"
                                placeholder="dd/mm/aaaa"
                                inputmode="numeric"
                            >
                        </div>
                    </div>

                    <h2 class="font-display mt-8 text-lg font-bold text-brand-900">Endereço</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-brand-700">CEP</label>
                            <input type="text" name="postcode" value="{{ old('postcode', $member->postcode) }}" class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-brand-700">Cidade</label>
                            <input type="text" name="city" value="{{ old('city', $member->city) }}" class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-brand-700">Rua</label>
                            <input type="text" name="street" value="{{ old('street', $member->street) }}" class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-brand-700">Número</label>
                            <input type="text" name="number" value="{{ old('number', $member->number) }}" class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-brand-700">Bairro</label>
                            <input type="text" name="neighborhood" value="{{ old('neighborhood', $member->neighborhood) }}" class="form-control">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1 block text-sm font-semibold text-brand-700">UF</label>
                                <input type="text" name="state" value="{{ old('state', $member->state) }}" class="form-control">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-semibold text-brand-700">Complemento</label>
                                <input type="text" name="complement" value="{{ old('complement', $member->complement) }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <h2 class="font-display mt-8 text-lg font-bold text-brand-900">Alterar senha</h2>
                    <p class="mt-1 text-xs text-slate-500">Deixe em branco para manter a senha atual.</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-3">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-brand-700">Senha atual</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-brand-700">Nova senha</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-brand-700">Confirmar nova senha</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="btn-primary">Salvar alterações</button>
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
                flatpickr('#birthday', { dateFormat: 'd/m/Y', maxDate: 'today', locale: FlatpickrPortuguese, disableMobile: true });
            }

            var foto = document.getElementById('foto');
            var previewWrapper = document.getElementById('avatar-preview');

            foto.addEventListener('change', function () {
                if (!foto.files || !foto.files[0]) {
                    return;
                }

                var reader = new FileReader();
                reader.onload = function (e) {
                    if (previewWrapper.tagName === 'IMG') {
                        previewWrapper.src = e.target.result;
                    } else {
                        var img = document.createElement('img');
                        img.id = 'avatar-preview';
                        img.src = e.target.result;
                        img.alt = 'Foto do perfil';
                        img.className = 'h-20 w-20 rounded-full object-cover ring-2 ring-brand-200';
                        previewWrapper.replaceWith(img);
                        previewWrapper = img;
                    }
                };
                reader.readAsDataURL(foto.files[0]);
            });
        });
    </script>
@endpush
