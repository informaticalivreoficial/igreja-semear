<div class="max-w-6xl mx-auto space-y-6">    

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LISTA --}}
        <div class="lg:col-span-7">
            @if($accounts->isEmpty())
                <div class="bg-white rounded-3xl p-16 text-center" style="border: 1.5px dashed #e8e4d8;">
                    <div class="w-16 h-16 mx-auto rounded-3xl flex items-center justify-center mb-4"
                         style="background: rgba(22,163,183,0.08);">
                        <svg class="w-8 h-8" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M3 21h18M3 10h18M3 6l9-3 9 3M4 10v11M8 10v11M12 10v11M16 10v11M20 10v11"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-extrabold mb-2" style="color: #051e34;">Nenhuma conta cadastrada</h2>
                    <p class="text-sm mb-6" style="color: #87c2c0;">Cadastre uma conta para receber seus saques.</p>
                    <button wire:click="openModal()"
                        class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-sm font-bold"
                        style="background: #23c55e; color: white;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Cadastrar conta
                    </button>
                </div>

            @else
                <div class="space-y-3">
                    @foreach($accounts as $account)
                        <div class="bg-white rounded-3xl p-5 transition"
                             style="border: {{ $account->is_default ? '2px solid #23c55e' : '1px solid #e8e4d8' }};">
                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0"
                                     style="background: {{ $account->type === 'pix' ? 'rgba(35,197,94,0.1)' : 'rgba(22,163,183,0.1)' }};">
                                    @if($account->type === 'pix')
                                        <svg class="w-6 h-6" style="color: #23c55e;" viewBox="0 0 512 512" fill="currentColor">
                                            <path d="M242.4 292.5C247.8 287.1 257.1 287.1 262.5 292.5L339.5 369.5C357.6 387.6 387.4 387.6 405.5 369.5L412.5 362.5L331.5 281.5C313.4 263.4 313.4 233.6 331.5 215.5L412.5 134.5L405.5 127.5C387.4 109.4 357.6 109.4 339.5 127.5L262.5 204.5C257.1 209.9 247.8 209.9 242.4 204.5L165.5 127.5C147.4 109.4 117.6 109.4 99.5 127.5L92.5 134.5L173.5 215.5C191.6 233.6 191.6 263.4 173.5 281.5L92.5 362.5L99.5 369.5C117.6 387.6 147.4 387.6 165.5 369.5L242.4 292.5z"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M3 21h18M3 10h18M3 6l9-3 9 3M4 10v11M8 10v11M12 10v11M16 10v11M20 10v11"/>
                                        </svg>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        <p class="font-extrabold text-sm" style="color: #051e34;">
                                            {{ $account->holder_name }}
                                        </p>
                                        @if($account->is_default)
                                            <span class="px-2 py-0.5 rounded-full text-xs font-bold"
                                                  style="background: rgba(35,197,94,0.1); color: #15803d;">
                                                Principal
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs" style="color: #87c2c0;">{{ $account->label }}</p>
                                    <p class="text-xs mt-0.5" style="color: #c5bfb2;">{{ $account->holder_document }}</p>
                                </div>

                                <div class="flex items-center gap-2 shrink-0">
                                    @if(!$account->is_default)
                                        <button wire:click="setDefault({{ $account->id }})"
                                            class="px-3 py-2 rounded-xl text-xs font-bold transition"
                                            style="background: rgba(35,197,94,0.08); color: #15803d;">
                                            Definir principal
                                        </button>
                                    @endif
                                    <button wire:click="openModal({{ $account->id }})"
                                        class="w-9 h-9 rounded-xl flex items-center justify-center transition"
                                        style="background: rgba(22,163,183,0.08); color: #16a3b7;">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="setDeleteId({{ $account->id }})"
                                        class="w-9 h-9 rounded-xl flex items-center justify-center transition"
                                        style="background: rgba(239,68,68,0.08); color: #dc2626;">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/>
                                        </svg>
                                    </button>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- FORMULÁRIO INLINE --}}
        <div class="lg:col-span-5">
            <div class="bg-white rounded-3xl p-6 sticky top-6" style="border: 1px solid #e8e4d8;">

                <h3 class="font-extrabold text-base mb-5" style="color: #051e34;">
                    {{ $editingId ? 'Editar conta' : 'Nova conta bancária' }}
                </h3>

                {{-- Tipo --}}
                <div class="grid grid-cols-2 gap-3 mb-5">
                    <button wire:click="$set('type', 'pix')"
                            class="p-3 rounded-2xl text-sm font-bold transition text-center"
                            style="border: 2px solid {{ $type === 'pix' ? '#23c55e' : '#e8e4d8' }}; background: {{ $type === 'pix' ? 'rgba(35,197,94,0.06)' : 'white' }}; color: {{ $type === 'pix' ? '#15803d' : '#87c2c0' }};">
                        PIX
                    </button>
                    <button wire:click="$set('type', 'ted')"
                            class="p-3 rounded-2xl text-sm font-bold transition text-center"
                            style="border: 2px solid {{ $type === 'ted' ? '#16a3b7' : '#e8e4d8' }}; background: {{ $type === 'ted' ? 'rgba(22,163,183,0.06)' : 'white' }}; color: {{ $type === 'ted' ? '#16a3b7' : '#87c2c0' }};">
                        TED
                    </button>
                </div>

                <div class="space-y-4">

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-xs font-bold mb-1.5" style="color: #051e34;">Nome do titular</label>
                            <input wire:model="holder_name" type="text" placeholder="Nome completo"
                                class="w-full h-11 px-4 rounded-2xl text-sm outline-none"
                                style="border: 1.5px solid #e8e4d8; color: #051e34;">
                            @error('holder_name') <p class="text-xs mt-1" style="color: #dc2626;">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold mb-1.5" style="color: #051e34;">CPF / CNPJ</label>
                            <input wire:model="holder_document" type="text" placeholder="000.000.000-00"
                                class="w-full h-11 px-4 rounded-2xl text-sm outline-none"
                                style="border: 1.5px solid #e8e4d8; color: #051e34;">
                            @error('holder_document') <p class="text-xs mt-1" style="color: #dc2626;">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    @if($type === 'pix')
                        <div>
                            <label class="block text-xs font-bold mb-1.5" style="color: #051e34;">Tipo de chave</label>
                            <select wire:model="pix_type"
                                class="w-full h-11 px-4 rounded-2xl text-sm outline-none"
                                style="border: 1.5px solid #e8e4d8; color: #051e34;">
                                <option value="cpf">CPF</option>
                                <option value="cnpj">CNPJ</option>
                                <option value="email">E-mail</option>
                                <option value="phone">Telefone</option>
                                <option value="random">Chave aleatória</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold mb-1.5" style="color: #051e34;">Chave PIX</label>
                            <input wire:model="pix_key" type="text" placeholder="Sua chave PIX"
                                class="w-full h-11 px-4 rounded-2xl text-sm outline-none"
                                style="border: 1.5px solid #e8e4d8; color: #051e34;">
                            @error('pix_key') <p class="text-xs mt-1" style="color: #dc2626;">{{ $message }}</p> @enderror
                        </div>
                    @endif

                    @if($type === 'ted')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold mb-1.5" style="color: #051e34;">Código do banco</label>
                                <input wire:model="bank_code" type="text" placeholder="001"
                                    class="w-full h-11 px-4 rounded-2xl text-sm outline-none"
                                    style="border: 1.5px solid #e8e4d8; color: #051e34;">
                                @error('bank_code') <p class="text-xs mt-1" style="color: #dc2626;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1.5" style="color: #051e34;">Nome do banco</label>
                                <input wire:model="bank_name" type="text" placeholder="Banco do Brasil"
                                    class="w-full h-11 px-4 rounded-2xl text-sm outline-none"
                                    style="border: 1.5px solid #e8e4d8; color: #051e34;">
                                @error('bank_name') <p class="text-xs mt-1" style="color: #dc2626;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block text-xs font-bold mb-1.5" style="color: #051e34;">Agência</label>
                                <input wire:model="agency" type="text" placeholder="0001"
                                    class="w-full h-11 px-4 rounded-2xl text-sm outline-none"
                                    style="border: 1.5px solid #e8e4d8; color: #051e34;">
                                @error('agency') <p class="text-xs mt-1" style="color: #dc2626;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1.5" style="color: #051e34;">Conta</label>
                                <input wire:model="account" type="text" placeholder="00000"
                                    class="w-full h-11 px-4 rounded-2xl text-sm outline-none"
                                    style="border: 1.5px solid #e8e4d8; color: #051e34;">
                                @error('account') <p class="text-xs mt-1" style="color: #dc2626;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold mb-1.5" style="color: #051e34;">Dígito</label>
                                <input wire:model="account_digit" type="text" placeholder="0"
                                    class="w-full h-11 px-4 rounded-2xl text-sm outline-none"
                                    style="border: 1.5px solid #e8e4d8; color: #051e34;">
                                @error('account_digit') <p class="text-xs mt-1" style="color: #dc2626;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold mb-1.5" style="color: #051e34;">Tipo de conta</label>
                            <select wire:model="account_type"
                                class="w-full h-11 px-4 rounded-2xl text-sm outline-none"
                                style="border: 1.5px solid #e8e4d8; color: #051e34;">
                                <option value="checking">Conta corrente</option>
                                <option value="savings">Conta poupança</option>
                            </select>
                        </div>
                    @endif

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" wire:model="is_default" class="w-4 h-4 rounded">
                        <span class="text-sm font-semibold" style="color: #051e34;">Definir como conta principal</span>
                    </label>

                </div>

                <div class="flex gap-3 mt-6">
                    <button wire:click="resetForm()"
                            class="flex-1 h-12 rounded-2xl text-sm font-bold"
                            style="border: 1.5px solid #e8e4d8; color: #87c2c0;">
                        Limpar
                    </button>
                    <button wire:click="save()"
                            wire:loading.attr="disabled"
                            class="flex-1 h-12 rounded-2xl text-sm font-bold transition"
                            style="background: #23c55e; color: white;">
                        <span wire:loading.remove wire:target="save">{{ $editingId ? 'Atualizar' : 'Cadastrar' }}</span>
                        <span wire:loading wire:target="save">Salvando...</span>
                    </button>
                </div>

            </div>
        </div>

    </div>

</div>