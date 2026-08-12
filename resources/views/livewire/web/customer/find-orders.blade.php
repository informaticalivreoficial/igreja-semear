<div class="max-w-md mx-auto py-16 px-4">
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Acompanhar meu pedido</h2>

        @if(!$sent)
            <p class="text-gray-500 text-sm mb-6">Digite o CPF usado na compra. Vamos enviar um link de acesso para o seu e-mail.</p>

            <label class="block text-sm font-semibold text-gray-700 mb-2">CPF</label>
            <input wire:model="cpf" type="text" x-mask="999.999.999-99" placeholder="000.000.000-00"
                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none mb-2">
            @error('cpf') <div class="text-red-500 text-sm mb-4">{{ $message }}</div> @enderror

            <button wire:click="send" wire:loading.attr="disabled"
                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-3 rounded-xl mt-4">
                <span wire:loading.remove>Enviar link de acesso</span>
                <span wire:loading>Enviando...</span>
            </button>
        @else
            <div class="text-center py-6">
                <p class="text-gray-700">Se o CPF estiver cadastrado, você vai receber um e-mail com o link de acesso aos seus pedidos em instantes.</p>
            </div>
        @endif
    </div>
</div>