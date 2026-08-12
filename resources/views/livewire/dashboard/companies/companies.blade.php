<div>
    @section('title', $title)

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-search mr-2"></i> Empresas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Empresas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 -m-4 p-4 lg:p-6" x-data="{ showModal: false, imageUrl: '' }">

        {{-- HEADER: busca + criar --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <div class="relative w-full sm:max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Pesquisar empresa..."
                    class="w-full h-11 pl-10 pr-4 rounded-xl border border-slate-200 bg-white text-sm outline-none focus:border-blue-400 transition">
            </div>

            <a href="{{ route('admin.companies.create') }}"
               class="inline-flex items-center justify-center gap-2 h-11 px-5 rounded-xl bg-slate-900 text-white text-sm font-bold hover:bg-slate-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Cadastrar Nova
            </a>
        </div>

        {{-- GRID DE CARDS --}}
        @if(!empty($companies) && $companies->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($companies as $company)
                    <div class="bg-white rounded-2xl border {{ $company->status ? 'border-slate-100' : 'border-amber-200' }} overflow-hidden hover:shadow-md transition-shadow">

                        {{-- HEADER DO CARD --}}
                        <div class="p-3 flex items-start gap-3 {{ $company->status ? '' : 'bg-amber-50/50' }}">
                            <img
                                src="{{ $company->getLogoUrl() }}"
                                alt="{{ $company->alias_name }}"
                                class="w-14 h-14 rounded-xl object-cover cursor-pointer border border-slate-100 shrink-0 hover:scale-105 transition-transform"
                                @click="showModal = true; imageUrl = '{{ addslashes($company->getLogoUrl()) }}'"
                            />
                            <div class="min-w-0 flex-1">

    <div class="flex items-center gap-2">
        <p class="text-sm font-bold text-slate-900 truncate">
            {{ $company->alias_name }}
        </p>

        <button
            type="button"
            wire:click="toggleHighlight({{ $company->id }})"
            class="flex items-center justify-center w-6 h-6 rounded-full transition-colors shrink-0
                {{ $company->highlight
                    ? 'bg-green-100 text-green-600 hover:bg-green-200'
                    : 'bg-slate-100 text-slate-400 hover:bg-slate-200' }}"
            title="{{ $company->highlight ? 'Empresa verificada' : 'Empresa não verificada' }}"
        >
            <i class="fas fa-shield-alt text-xs"></i>
        </button>
    </div>

    <p class="text-xs text-slate-400 truncate mt-1">
        {{ $company->responsable_name }}
    </p>

    <div class="flex items-center gap-1.5 mt-2">
        <span class="w-1.5 h-1.5 rounded-full {{ $company->status ? 'bg-green-500' : 'bg-amber-500' }}"></span>

        <span class="text-[10px] font-bold uppercase tracking-wide {{ $company->status ? 'text-green-600' : 'text-amber-600' }}">
            {{ $company->status ? 'Ativa' : 'Inativa' }}
        </span>
    </div>

</div>                            
                            <x-forms.switch-toggle
                                wire:key="safe-switch-{{ $company->id }}"
                                wire:click="toggleStatus({{ $company->id }})"
                                :checked="$company->status"
                                size="sm"
                                color="green"
                            />
                        </div>

                        {{-- MÉTRICAS --}}
                        <div class="grid grid-cols-2 gap-px bg-slate-100 border-y border-slate-100">
                            <div class="bg-white p-4">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Saldo disponível</p>
                                <p class="text-base font-black text-green-600">R$ {{ number_format($company->available_balance, 2, ',', '.') }}</p>
                            </div>
                            <div class="bg-white p-4">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Views</p>
                                <p class="text-base font-black text-slate-800">{{ $company->views ?? 0 }}</p>
                            </div>
                        </div>

                        {{-- SAQUE EM ABERTO --}}
                        @if($company->pending_withdrawals_count > 0)
                            <a href="{{ route('admin.withdrawals.index') }}"
                               class="flex items-center justify-between px-5 py-3 bg-amber-50 hover:bg-amber-100 transition-colors">
                                <span class="flex items-center gap-2 text-xs font-bold text-amber-700">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M12 6v6l4 2"/>
                                    </svg>
                                    {{ $company->pending_withdrawals_count }} {{ $company->pending_withdrawals_count === 1 ? 'saque pendente' : 'saques pendentes' }}
                                </span>
                                <span class="text-xs font-black text-amber-700">
                                    R$ {{ number_format($company->pending_withdrawals_amount ?? 0, 2, ',', '.') }}
                                </span>
                            </a>
                        @endif

                        {{-- AÇÕES --}}
                        <div class="flex items-center gap-2 p-4">
                            <a href="{{ route('admin.companies.edit', ['company' => $company->id]) }}"
                               class="flex-1 h-10 inline-flex items-center justify-center rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition-colors">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar
                            </a>
                            <a href="{{-- rota de visualização pública --}}" target="_blank"
                               class="h-10 w-10 inline-flex items-center justify-center rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors" title="Visualizar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8"/>
                                    <path d="M21 21l-4.35-4.35"/>
                                </svg>
                            </a>
                            @if(auth()->user()->isSuperAdmin())
                                <button type="button" wire:click="setDeleteId({{ $company->id }})"
                                        class="h-10 w-10 inline-flex items-center justify-center rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition-colors" title="Excluir">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/>
                                    </svg>
                                </button>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- MODAL DE IMAGEM --}}
            <div x-show="showModal" x-cloak
                 class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-[9999]" x-transition>
                <div class="relative">
                    <img :src="imageUrl" class="max-w-[70vw] max-h-[70vh] object-contain mx-auto rounded shadow-lg">
                    <button type="button" @click="showModal = false"
                            class="absolute top-2 right-2 text-white text-xl bg-black bg-opacity-50 rounded-full px-2 py-1 hover:bg-opacity-75 transition">✕</button>
                </div>
            </div>

            <div class="mt-6">{{ $companies->links() }}</div>

        @else
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 py-16 text-center">
                <p class="text-sm font-bold text-slate-500">Não foram encontrados registros!</p>
            </div>
        @endif

    </div>
</div>

@push('scripts')
    <script>
    </script>
@endpush