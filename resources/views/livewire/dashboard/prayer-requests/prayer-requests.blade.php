<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-hands-praying"></i> Pedidos de oração</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Pedidos de oração</span>
        </nav>
    </div>

    <div class="card mt-6">
        <div class="card-header">
            <select wire:model.live="statusFilter" class="form-control form-control-sm w-44">
                <option value="">Todos</option>
                <option value="pendente">Pendente</option>
                <option value="respondido">Respondido</option>
            </select>
        </div>

        <div class="card-body p-0 sm:p-5">
            @if ($requests->count())
                <div class="grid gap-4 md:grid-cols-2">
                    @foreach ($requests as $request)
                        <div class="card overflow-hidden">
                            <div class="card-body p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $request->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $request->created_at->translatedFormat('d \d\e F \d\e Y') }}</p>
                                    </div>
                                    @if($request->status === 'respondido')
                                        <span class="badge badge-success">Respondido</span>
                                    @else
                                        <span class="badge badge-warning">Pendente</span>
                                    @endif
                                </div>

                                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $request->message }}</p>

                                @if($request->answer)
                                    <div class="mt-3 rounded-lg bg-gold-500/10 p-3 text-sm text-gold-900">
                                        <strong>Resposta:</strong> {{ $request->answer }}
                                    </div>
                                @endif

                                @if($request->email || $request->phone)
                                    <p class="mt-3 text-xs text-slate-400">
                                        @if($request->email) {{ $request->email }} @endif
                                        @if($request->phone) · {{ $request->phone }} @endif
                                    </p>
                                @endif

                                <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-3">
                                    <button wire:click="openAnswer({{ $request->id }})" class="btn btn-xs btn-primary">
                                        <i class="fas fa-reply"></i> Responder
                                    </button>
                                    <button wire:click="setDeleteId({{ $request->id }})" class="btn btn-xs btn-danger" title="Excluir"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">{{ $requests->links() }}</div>
            @else
                <div class="alert alert-info p-3">Nenhum pedido de oração encontrado.</div>
            @endif
        </div>
    </div>

    @if ($answeringId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" wire:click.self="closeAnswer">
            <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-800">Responder pedido</h3>
                    <button wire:click="closeAnswer" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times"></i></button>
                </div>

                <form wire:submit="saveAnswer" class="mt-5">
                    <label class="form-label">Mensagem de resposta</label>
                    <textarea wire:model="answer" rows="5" class="form-control" placeholder="Escreva a resposta/orientação..."></textarea>
                    @error('answer') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                    <div class="mt-6 flex justify-end gap-2">
                        <button type="button" wire:click="closeAnswer" class="btn btn-sm btn-default">Cancelar</button>
                        <button type="submit" class="btn btn-sm btn-primary">Salvar resposta</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
