<div class="min-h-screen flex" style="background: #faf7f2;">

    {{-- LADO ESQUERDO --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col justify-between p-12"
         style="background: linear-gradient(135deg, #1a2e1a 0%, #2d4a2a 50%, #1a2e1a 100%);">

        {{-- Elementos decorativos --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-full h-full"
                 style="background-image: radial-gradient(circle at 20% 30%, #c4a84a 0%, transparent 40%), radial-gradient(circle at 80% 70%, #c4a84a 0%, transparent 40%);">
            </div>
        </div>

        {{-- Vitral decorativo --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-5">
            <svg width="300" height="400" viewBox="0 0 100 140">
                <rect x="40" y="0" width="20" height="140" fill="#c4a84a"/>
                <rect x="0" y="50" width="100" height="20" fill="#c4a84a"/>
                <circle cx="50" cy="70" r="15" fill="none" stroke="#c4a84a" stroke-width="2"/>
            </svg>
        </div>

        {{-- Padrão geométrico --}}
        <div class="absolute bottom-10 right-10 opacity-10">
            <svg width="200" height="200" viewBox="0 0 100 100">
                <polygon points="50,10 90,40 80,80 20,80 10,40" fill="none" stroke="#c4a84a" stroke-width="1"/>
                <polygon points="50,25 75,45 70,70 30,70 25,45" fill="none" stroke="#c4a84a" stroke-width="0.5"/>
                <circle cx="50" cy="50" r="8" fill="none" stroke="#c4a84a" stroke-width="0.5"/>
            </svg>
        </div>

        {{-- Logo --}}
        <div class="relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-full flex items-center justify-center"
                     style="background: rgba(196,168,74,0.15); border: 2px solid rgba(196,168,74,0.3);">
                    <svg class="w-7 h-7" style="color: #c4a84a;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                        <path d="M2 17l10 5 10-5"/>
                        <path d="M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <div>
                    <span class="text-lg font-bold text-white block" style="font-family: 'Georgia', serif; letter-spacing: 2px;">
                        {{ $config->app_name ?? 'Comunidade Cristã Semear' }}
                    </span>
                    <span class="text-xs" style="color: rgba(196,168,74,0.7); letter-spacing: 3px;">Semear</span>
                </div>
            </div>
        </div>

        {{-- Texto inspirador --}}
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full mb-6 text-xs font-bold uppercase tracking-widest"
                 style="background: rgba(196,168,74,0.15); border: 1px solid rgba(196,168,74,0.3); color: #c4a84a;">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
                Comunidade de fé
            </div>
            <h2 class="text-4xl font-bold text-white mb-4 leading-tight" style="font-family: 'Georgia', serif;">
                Bem-vindo à<br>
                <span style="color: #c4a84a;">Casa do Pai</span>
            </h2>
            <p class="text-base leading-relaxed" style="color: rgba(255,255,255,0.6); max-width: 320px; font-style: italic;">
                "O Senhor é meu pastor, nada me faltará."<br>
                <span class="text-xs" style="color: rgba(196,168,74,0.5);">Salmo 23:1</span>
            </p>
            <div class="mt-4 flex items-center gap-2">
                <span class="text-xs" style="color: rgba(255,255,255,0.3);">📍</span>
                <span class="text-xs" style="color: rgba(255,255,255,0.3);">Ubatuba-SP</span>
            </div>
        </div>

        <div class="relative z-10">
            <p class="text-xs" style="color: rgba(255,255,255,0.2);">
                © {{ date('Y') }} Comunidade Cristã Semear - Todos os direitos reservados
            </p>
        </div>
    </div>

    {{-- LADO DIREITO --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-8">
        <div class="w-full max-w-md">

            {{-- Header --}}
            <div class="mb-8 text-center lg:text-left">
                <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full mb-4"
                     style="background: rgba(196,168,74,0.1); border: 1px solid rgba(196,168,74,0.25); color: #c4a84a;">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                        <path d="M2 17l10 5 10-5"/>
                        <path d="M2 12l10 5 10-5"/>
                    </svg>
                    Acesso seguro
                </div>
                <h1 class="text-3xl font-bold mb-2" style="font-family: 'Georgia', serif; color: #1a2e1a;">
                    Entrar na plataforma
                </h1>
                <p class="text-sm" style="color: #8a7a6b;">
                    Ainda não é membro?
                    <a href="{{ route('register') }}" style="color: #c4a84a; font-weight: 600;">Cadastre-se aqui</a>
                </p>
            </div>

            {{-- Erro geral --}}
            @error('login_failed')
                <div class="flex items-center gap-3 px-4 py-3 rounded-xl mb-6" style="background: rgba(180,60,60,0.08); border: 1px solid rgba(180,60,60,0.2);">
                    <svg class="w-4 h-4 shrink-0" style="color: #b43c3c;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 8v4M12 16h.01"/>
                    </svg>
                    <p class="text-sm" style="color: #b43c3c;">{{ $message }}</p>
                </div>
            @enderror

            {{-- Form --}}
            <form wire:submit="login" class="space-y-5">

                {{-- Email --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold" style="color: #1a2e1a; font-family: 'Georgia', serif;">E-mail</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #8a7a6b;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,12 2,6"/>
                        </svg>
                        <input
                            type="email"
                            wire:model="email"
                            placeholder="seu@email.com"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition bg-white"
                            style="border-color: #d4c8b8; color: #1a2e1a; font-family: 'Georgia', serif;"
                            onfocus="this.style.borderColor='#c4a84a'; this.style.boxShadow='0 0 0 3px rgba(196,168,74,0.15)'"
                            onblur="this.style.borderColor='#d4c8b8'; this.style.boxShadow='none'"
                        >
                    </div>
                    @error('email')
                        <p class="text-xs" style="color: #b43c3c;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Senha --}}
                <div class="flex flex-col gap-1.5">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-semibold" style="color: #1a2e1a; font-family: 'Georgia', serif;">Senha</label>
                        <a href="{{ route('password.request') }}" class="text-xs font-medium" style="color: #c4a84a;">
                            Esqueceu sua senha?
                        </a>
                    </div>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #8a7a6b;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                        <input
                            type="password"
                            wire:model="password"
                            placeholder="Sua senha"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition bg-white"
                            style="border-color: #d4c8b8; color: #1a2e1a; font-family: 'Georgia', serif;"
                            onfocus="this.style.borderColor='#c4a84a'; this.style.boxShadow='0 0 0 3px rgba(196,168,74,0.15)'"
                            onblur="this.style.borderColor='#d4c8b8'; this.style.boxShadow='none'"
                        >
                    </div>
                    @error('password')
                        <p class="text-xs" style="color: #b43c3c;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Lembrar --}}
                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        wire:model="remember"
                        id="remember"
                        class="rounded"
                        style="accent-color: #c4a84a;"
                    >
                    <label for="remember" class="text-sm" style="color: #8a7a6b;">Lembrar de mim</label>
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="login"
                        class="w-full flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm transition"
                        style="background: #c4a84a; color: #1a2e1a; box-shadow: 0 2px 0 #a88a3a; font-family: 'Georgia', serif; letter-spacing: 1px;"
                        onmouseover="this.style.background='#b4983a'; this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.background='#c4a84a'; this.style.transform='translateY(0)'"
                    >
                        <span wire:loading.remove wire:target="login" class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                <path d="M2 17l10 5 10-5"/>
                                <path d="M2 12l10 5 10-5"/>
                            </svg>
                            Entrar na comunidade
                        </span>
                        <span wire:loading wire:target="login" class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
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
        style="background: rgba(26,46,26,0.88); backdrop-filter: blur(6px);"
    >
        <div class="flex flex-col items-center gap-4">
            <div class="relative w-16 h-16">
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="animate-spin w-14 h-14" style="color: #c4a84a;" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                    </svg>
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-6 h-6" style="color: #f5f0e6;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                        <path d="M2 17l10 5 10-5"/>
                        <path d="M2 12l10 5 10-5"/>
                    </svg>
                </div>
            </div>
            <div class="text-center">
                <p class="font-bold text-white text-lg" style="font-family: 'Georgia', serif;">Entrando na comunidade...</p>
                <p class="text-sm mt-1" style="color: rgba(255,255,255,0.6);">Aguarde um momento em oração</p>
            </div>
        </div>
    </div>

</div>