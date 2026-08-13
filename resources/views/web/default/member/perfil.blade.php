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

    <section class="bg-slate-50 py-12">
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

                <form method="POST" action="{{ route('member.perfil.update') }}" class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                    @csrf

                    <h2 class="font-display text-lg font-bold text-slate-900">Dados pessoais</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-600">Nome completo *</label>
                            <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-600">E-mail *</label>
                            <input type="email" name="email" value="{{ old('email', $member->email ?? auth()->user()->email) }}" required class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-600">Telefone / WhatsApp</label>
                            <input type="text" name="cell_phone" value="{{ old('cell_phone', $member->cell_phone) }}" class="form-control" placeholder="(00) 00000-0000">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-600">Data de nascimento</label>
                            <input type="text" name="birthday" value="{{ old('birthday', $member->birthday?->format('d/m/Y')) }}" class="form-control" placeholder="dd/mm/aaaa">
                        </div>
                    </div>

                    <h2 class="font-display mt-8 text-lg font-bold text-slate-900">Endereço</h2>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-600">CEP</label>
                            <input type="text" name="postcode" value="{{ old('postcode', $member->postcode) }}" class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-600">Cidade</label>
                            <input type="text" name="city" value="{{ old('city', $member->city) }}" class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-600">Rua</label>
                            <input type="text" name="street" value="{{ old('street', $member->street) }}" class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-600">Número</label>
                            <input type="text" name="number" value="{{ old('number', $member->number) }}" class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-600">Bairro</label>
                            <input type="text" name="neighborhood" value="{{ old('neighborhood', $member->neighborhood) }}" class="form-control">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1 block text-sm font-semibold text-slate-600">UF</label>
                                <input type="text" name="state" value="{{ old('state', $member->state) }}" class="form-control">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-semibold text-slate-600">Complemento</label>
                                <input type="text" name="complement" value="{{ old('complement', $member->complement) }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <h2 class="font-display mt-8 text-lg font-bold text-slate-900">Alterar senha</h2>
                    <p class="mt-1 text-xs text-slate-500">Deixe em branco para manter a senha atual.</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-3">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-600">Senha atual</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-600">Nova senha</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-600">Confirmar nova senha</label>
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
