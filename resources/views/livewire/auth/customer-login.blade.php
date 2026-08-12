<div class="min-h-screen flex" style="background: #f5f3ee;">

    {{-- LADO ESQUERDO --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col justify-between p-12"
         style="background: linear-gradient(135deg, #051e34 0%, #0a3358 60%, #0e4a7a 100%);">

        <div class="absolute inset-0 opacity-20"
             style="background-image: radial-gradient(circle at 30% 70%, #16a3b7 0%, transparent 50%), radial-gradient(circle at 80% 20%, #fadd37 0%, transparent 40%);"></div>

        <div class="absolute bottom-0 right-0 opacity-10">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" style="width: 400px; height: 400px;">
                <circle cx="300" cy="300" r="200" fill="none" stroke="#16a3b7" stroke-width="1"/>
                <circle cx="300" cy="300" r="150" fill="none" stroke="#16a3b7" stroke-width="1"/>
                <circle cx="300" cy="300" r="100" fill="none" stroke="#fadd37" stroke-width="1"/>
            </svg>
        </div>

        {{-- Logo --}}
        <div class="relative z-10">
            <div class="flex items-center gap-3">
                <img
                    src="{{ $config->getlogoadmin() }}"
                    alt="{{ $config->app_name }}"
                    class="h-10 w-auto object-contain"
                    onerror="this.style.display='none'"
                >
            </div>
        </div>

        {{-- Texto --}}
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full mb-6 text-xs font-bold uppercase tracking-widest"
                 style="background: rgba(250,221,55,0.15); border: 1px solid rgba(250,221,55,0.3); color: #fadd37;">
                Área restrita
            </div>
            <h2 class="text-4xl font-extrabold text-white mb-4 leading-tight" style="font-family: 'Syne', sans-serif;">
                Bem-vindo<br>
                <span style="color: #fadd37;">de volta</span>
            </h2>
            <p class="text-base leading-relaxed" style="color: rgba(255,255,255,0.6); max-width: 320px;">
                Acesse sua conta para gerenciar seus passeios, reservas e muito mais.
            </p>
        </div>

        <div class="relative z-10">
            <p class="text-xs" style="color: rgba(255,255,255,0.3);">
                © {{ date('Y') }} {{ $config->app_name }}
            </p>
        </div>

    </div>

    {{-- LADO DIREITO --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">

            {{-- Header --}}
            <div class="mb-8">
                <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full mb-4"
                     style="background: rgba(22,163,183,0.1); border: 1px solid rgba(22,163,183,0.3); color: #16a3b7;">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    Acesso seguro
                </div>
                <h1 class="text-3xl font-extrabold mb-2" style="font-family: 'Syne', sans-serif; color: #051e34;">
                    Entrar na conta
                </h1>
                <p class="text-sm" style="color: #87c2c0;">
                    Ainda não tem conta?
                    <a href="{{ route('register.company') }}" style="color: #16a3b7; font-weight: 600;">Cadastre sua empresa</a>
                </p>
            </div>

            {{-- Erro geral --}}
            @error('login_failed')
                <div class="flex items-center gap-3 px-4 py-3 rounded-xl mb-6" style="background: rgba(229,62,62,0.08); border: 1px solid rgba(229,62,62,0.2);">
                    <svg class="w-4 h-4 shrink-0" style="color: #e53e3e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                    <p class="text-sm" style="color: #e53e3e;">{{ $message }}</p>
                </div>
            @enderror

            {{-- Form --}}
            <form wire:submit="login" class="space-y-4">

                {{-- Email --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">E-mail</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #b0a98a;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                        <input
                            type="email"
                            wire:model="email"
                            placeholder="seu@email.com"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >
                    </div>
                    @error('email')
                        <p class="text-xs" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Senha --}}
                <div class="flex flex-col gap-1.5">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-bold" style="color: #051e34;">Senha</label>
                        <a href="{{ route('password.request') }}" class="text-xs font-medium" style="color: #16a3b7;">
                            Esqueci minha senha
                        </a>
                    </div>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #b0a98a;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <input
                            type="password"
                            wire:model="password"
                            placeholder="Sua senha"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >
                    </div>
                    @error('password')
                        <p class="text-xs" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Lembrar --}}
                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        wire:model="remember"
                        id="remember"
                        class="rounded"
                        style="accent-color: #16a3b7;"
                    >
                    <label for="remember" class="text-sm" style="color: #87c2c0;">Lembrar de mim</label>
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="login"
                        class="w-full flex items-center justify-center gap-2 py-3 rounded-xl font-extrabold text-sm transition"
                        style="background: #16a3b7; color: white; box-shadow: 0 2px 0 #0e7a8a; font-family: 'Syne', sans-serif;"
                        onmouseover="this.style.background='#13919e'"
                        onmouseout="this.style.background='#16a3b7'"
                    >
                        <span wire:loading.remove wire:target="login" class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
                            Entrar na conta
                        </span>
                        <span wire:loading wire:target="login" class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                            Carregando...
                        </span>
                    </button>
                </div>

            </form>

        </div>
    </div>

    {{-- OVERLAY DE LOADING --}}
    <div
        wire:loading.flex
        wire:target="login"
        class="fixed inset-0 z-50 items-center justify-center"
        style="background: rgba(5,30,52,0.7); backdrop-filter: blur(4px);"
    >
        <div class="flex flex-col items-center gap-4">
            <div class="relative w-16 h-16">
                <svg class="animate-spin w-16 h-16" style="color: #16a3b7;" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-6 h-6" style="color: #fadd37;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 17l4-8 4 4 4-6 4 10"/></svg>
                </div>
            </div>
            <div class="text-center">
                <p class="font-bold text-white text-lg" style="font-family: 'Syne', sans-serif;">Efetuando login...</p>
                <p class="text-sm mt-1" style="color: rgba(255,255,255,0.6);">Aguarde um momento</p>
            </div>
        </div>
    </div>

</div>