<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-money-bill-wave"></i> {{ $donation?->exists ? 'Editar Doação' : 'Cadastrar Doação Manual' }}</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item"><a href="{{ route('admin.donations.index') }}">Doações</a></span>
            <span class="breadcrumb-item active">{{ $donation?->exists ? 'Editar' : 'Cadastrar' }}</span>
        </nav>
    </div>

    <form wire:submit.prevent="save" autocomplete="off">
        <div class="card">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="form-group">
                        <label class="labelforms"><b>Contribuinte</b></label>
                        <select class="form-control @error('member_id') is-invalid @enderror" wire:model="member_id">
                            <option value="">— Selecione —</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->user?->name ?? $member->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>*Tipo</b></label>
                        <select class="form-control @error('type') is-invalid @enderror" wire:model="type">
                            @foreach ($types as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>*Valor</b></label>
                        <input type="number" step="0.01" min="0.01" class="form-control @error('amount') is-invalid @enderror"
                            placeholder="0,00" wire:model="amount">
                        @error('amount')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>*Data</b></label>
                        <input type="date" class="form-control @error('donation_date') is-invalid @enderror"
                            wire:model="donation_date">
                        @error('donation_date')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>Método de pagamento</b></label>
                        <select class="form-control @error('payment_method') is-invalid @enderror" wire:model="payment_method">
                            <option value="">— Selecione —</option>
                            <option value="dinheiro">Dinheiro</option>
                            <option value="pix">PIX</option>
                            <option value="transferencia">Transferência</option>
                            <option value="debito">Débito</option>
                            <option value="credito">Crédito</option>
                            <option value="boleto">Boleto</option>
                            <option value="outro">Outro</option>
                        </select>
                        @error('payment_method')
                            <span class="error erro-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="labelforms"><b>Anônimo</b></label>
                        <div class="pt-2">
                            <x-forms.switch-toggle
                                wire:model="is_anonymous"
                                :checked="$is_anonymous"
                                size="md"
                                color="green"
                            />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="labelforms"><b>Descrição / Observações</b></label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                        rows="3" placeholder="Observações sobre a doação" wire:model="description"></textarea>
                    @error('description')
                        <span class="error erro-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-4 flex justify-end pb-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-check mr-2"></i>{{ $donation?->exists ? 'Atualizar Agora' : 'Cadastrar Agora' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>