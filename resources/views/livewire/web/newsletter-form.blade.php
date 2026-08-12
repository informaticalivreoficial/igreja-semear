<div>
    @if($success)
        <div class="flex items-center gap-3 p-4 rounded-xl"
             style="background: rgba(35,197,94,0.1); border: 1px solid rgba(35,197,94,0.2);">
            <svg class="w-5 h-5 shrink-0" style="color: #23c55e;" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-sm font-bold" style="color: #23c55e;">Inscrição realizada!</p>
                <p class="text-xs" style="color: #b8d4e8;">Você receberá nossas novidades em breve.</p>
            </div>
        </div>
    @else
        <form wire:submit.prevent="subscribe" class="flex flex-col gap-2">
    
            <div class="flex gap-2">
                <input
                    wire:model="email"
                    type="email"
                    placeholder="seu@email.com"
                    class="flex-1 px-3 py-2 text-sm rounded-lg border outline-none transition-all"
                    style="background: rgba(10,25,41,0.6); border-color: {{ $errors->has('email') ? '#dc2626' : 'rgba(107,163,200,0.25)' }}; color: #e8f0f8;"
                >
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all hover:scale-105 shrink-0"
                    style="background: linear-gradient(135deg, #6ba3c8, #2e6b8a); color: #fff;">
                    <span wire:loading.remove wire:target="subscribe">Inscrever</span>
                    <span wire:loading wire:target="subscribe">...</span>
                </button>
            </div>

            @error('email')
                <p class="text-xs" style="color: #f87171;">{{ $message }}</p>
            @enderror

        </form>
    @endif
</div>