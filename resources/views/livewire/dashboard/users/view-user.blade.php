<div>
    @section('title', 'Perfil')

    <div class="content-header">
        <h1><i class="fas fa-user"></i> Perfil</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Membros</a></span>
            <span class="breadcrumb-item active">Perfil</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">
        {{-- Card de perfil --}}
        <div class="card h-fit overflow-hidden">
            <div class="h-24 bg-gradient-to-r from-forest-900 to-forest-600"></div>
            <div class="px-6 pb-6">
                @php
                    if(!empty($user->avatar) && \Illuminate\Support\Facades\Storage::exists($user->avatar)){
                        $cover = \Illuminate\Support\Facades\Storage::url($user->avatar);
                    } else {
                        if($user->gender == 'masculino'){
                            $cover = url(asset('backend/assets/images/avatar5.png'));
                        }else{
                            $cover = url(asset('backend/assets/images/avatar3.png'));
                        }
                    }
                @endphp
                <div class="-mt-12 mb-3 flex justify-center">
                    <img class="h-24 w-24 rounded-full object-cover ring-4 ring-white shadow-lg" src="{{ $cover }}" alt="{{ $user->name }}">
                </div>

                <h3 class="text-center text-lg font-bold text-slate-800">{{ $user->name }}</h3>
                <p class="text-center text-sm text-slate-500">
                    {{ $user->getRoleNames()->implode(', ') ?: '—' }}
                </p>

                <ul class="mt-5 divide-y divide-slate-100 rounded-xl border border-slate-100 bg-slate-50/60">
                    <li class="flex items-center justify-between px-4 py-3 text-sm">
                        <span class="text-slate-500">Celular</span>
                        <span class="font-medium text-slate-700">{{ $user->cell_phone }}</span>
                    </li>
                    <li class="flex items-center justify-between px-4 py-3 text-sm">
                        <span class="text-slate-500">WhatsApp</span>
                        <span class="font-medium text-slate-700">{{ $user->whatsapp }}</span>
                    </li>
                    <li class="flex items-center justify-between px-4 py-3 text-sm">
                        <span class="text-slate-500">Status</span>
                        <span>
                            @if ($user->status)
                                <span class="badge badge-success">Ativo</span>
                            @else
                                <span class="badge badge-danger">Inativo</span>
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Informações --}}
        <div class="lg:col-span-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-id-card text-forest-600"></i> Informações Pessoais</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-2 sm:grid-cols-2 lg:grid-cols-3">
                        <p class="text-sm text-slate-600"><b class="text-slate-800">CPF:</b> {{ $user->cpf ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">RG:</b> {{ $user->rg ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">RG/Expedição:</b> {{ $user->rg_expedition ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">Nascimento:</b> {{ $user->birthday ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">Naturalidade:</b> {{ $user->naturalness ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">Estado Civil:</b> {{ ucfirst($user->civil_status ?? '—') }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-phone text-forest-600"></i> Informações de Contato</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-2 sm:grid-cols-2 lg:grid-cols-4">
                        <p class="text-sm text-slate-600"><b class="text-slate-800">Celular:</b> {{ $user->cell_phone ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">WhatsApp:</b> {{ $user->whatsapp ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">E-mail:</b> {{ $user->email ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">E-mail Adicional:</b> {{ $user->additional_email ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-map-marker-alt text-forest-600"></i> Endereço</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-2 sm:grid-cols-2 lg:grid-cols-4">
                        <p class="text-sm text-slate-600"><b class="text-slate-800">Endereço:</b> {{ $user->street ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">Bairro:</b> {{ $user->neighborhood ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">Número:</b> {{ $user->number ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">CEP:</b> {{ $user->postcode ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">Complemento:</b> {{ $user->complement ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">Cidade:</b> {{ $user->city ?? '—' }}</p>
                        <p class="text-sm text-slate-600"><b class="text-slate-800">UF:</b> {{ $user->state ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
