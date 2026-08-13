<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-hand-holding-heart mr-2"></i> {{ $offering?->exists ? 'Editar Oferta' : 'Cadastrar Oferta' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.offerings.index') }}">Ofertas</a></li>
                        <li class="breadcrumb-item active">{{ $offering?->exists ? 'Editar' : 'Cadastrar' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save" autocomplete="off">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
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
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="labelforms"><b>*Tipo</b></label>
                            <select class="form-control" wire:model="type">
                                <option value="oferta">Oferta</option>
                                <option value="dizimo">Dízimo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="labelforms"><b>*Valor (R$)</b></label>
                            <input type="number" step="0.01" min="0" class="form-control @error('amount') is-invalid @enderror"
                                placeholder="0,00" wire:model="amount">
                            @error('amount')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="labelforms"><b>*Data</b></label>
                            <input type="date" class="form-control @error('offering_date') is-invalid @enderror"
                                wire:model="offering_date">
                            @error('offering_date')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
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
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Observações</b></label>
                            <input type="text" class="form-control" placeholder="Anotações da oferta" wire:model="notes">
                        </div>
                    </div>
                </div>

                <div class="row text-right">
                    <div class="col-12 pb-4 mt-3">
                        <button type="submit" class="btn btn-lg btn-success p-3">
                            <i class="nav-icon fas fa-check mr-2"></i>{{ $offering?->exists ? 'Atualizar Agora' : 'Cadastrar Agora' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
