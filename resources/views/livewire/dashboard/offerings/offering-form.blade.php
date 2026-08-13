<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-hand-holding-heart"></i> {{ $offering?->exists ? 'Editar Oferta' : 'Cadastrar Oferta' }}</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item"><a href="{{ route('admin.offerings.index') }}">Ofertas</a></span>
            <span class="breadcrumb-item active">{{ $offering?->exists ? 'Editar' : 'Cadastrar' }}</span>
        </nav>
    </div>

    <form wire:submit.prevent="save" autocomplete="off">
        <div class="card">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="form-group">
                        <label class="labelforms"><b>*Membro</b></label>
                        <select class="form-control @error('user_id') is-invalid @enderror" wire:model="user_id">
                            <option value="">Selecione</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>*Tipo</b></label>
                        <select class="form-control" wire:model="type">
                            <option value="oferta">Oferta</option>
                            <option value="dizimo">Dízimo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>*Valor (R$)</b></label>
                        <input type="number" step="0.01" min="0" class="form-control @error('amount') is-invalid @enderror"
                            placeholder="0,00" wire:model="amount">
                        @error('amount')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>*Data</b></label>
                        <input type="date" class="form-control @error('offering_date') is-invalid @enderror"
                            wire:model="offering_date">
                        @error('offering_date')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Forma de pagamento</b></label>
                        <select class="form-control" wire:model="payment_method">
                            <option value="">Selecione</option>
                            <option value="pix">Pix</option>
                            <option value="dinheiro">Dinheiro</option>
                            <option value="cartao">Cartão</option>
                            <option value="transferencia">Transferência</option>
                            <option value="boleto">Boleto</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="labelforms"><b>Observações</b></label>
                        <input type="text" class="form-control" placeholder="Anotações da oferta" wire:model="notes">
                    </div>
                </div>

                <div class="mt-4 flex justify-end pb-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-check mr-2"></i>{{ $offering?->exists ? 'Atualizar Agora' : 'Cadastrar Agora' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
