<div class="min-h-screen flex" style="background: #fafaf8;">

    {{-- LADO ESQUERDO — decorativo --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col justify-between p-12"
        style="background: linear-gradient(135deg, #051e34 0%, #0a3358 60%, #0e4a7a 100%);">

        {{-- Efeito de brilho --}}
        <div class="absolute inset-0 opacity-20"
            style="background-image: radial-gradient(circle at 30% 70%, #16a3b7 0%, transparent 50%), radial-gradient(circle at 80% 20%, #fadd37 0%, transparent 40%);"></div>

        {{-- Onda decorativa --}}
        <div class="absolute bottom-0 right-0 opacity-10">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" style="width: 400px; height: 400px;">
                <circle cx="300" cy="300" r="200" fill="none" stroke="#16a3b7" stroke-width="1"/>
                <circle cx="300" cy="300" r="150" fill="none" stroke="#16a3b7" stroke-width="1"/>
                <circle cx="300" cy="300" r="100" fill="none" stroke="#fadd37" stroke-width="1"/>
            </svg>
        </div>

        {{-- Logo --}}
        <div class="relative z-10">
            <a href="#" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(22,163,183,0.2); border: 1px solid rgba(22,163,183,0.4);">
                    <svg class="w-5 h-5" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 17l4-8 4 4 4-6 4 10"/></svg>
                </div>
                <span class="text-white font-bold text-lg" style="font-family: 'Syne', sans-serif;">App Name</span>
            </a>
        </div>

        {{-- Conteúdo central (adaptado para ser genérico ou removido se não for necessário) --}}
        <div class="relative z-10">
            <h2 class="text-4xl font-extrabold text-white mb-4 leading-tight" style="font-family: 'Syne', sans-serif;">
                Verificação de E-mail
            </h2>
            <p class="text-base leading-relaxed" style="color: rgba(255,255,255,0.6); max-width: 340px;">
                Mantenha sua conta segura e atualizada. Verifique seu e-mail para continuar.
            </p>
        </div>

        {{-- Rodapé --}}
        <div class="relative z-10">
            <p class="text-xs" style="color: rgba(255,255,255,0.3);">
                © {{ date('Y') }} App Name
            </p>
        </div>

    </div>

    {{-- LADO DIREITO — formulário de verificação de e-mail --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 ">

        <div class="w-full max-w-md">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold mb-2" style="font-family: 'Syne', sans-serif; color: #051e34;">
                    Verifique seu email
                </h1>
                <p class="text-sm" style="color: #87c2c0;">
                    Enviamos um link de confirmação para seu email.
                </p>
            </div>

            <button
                wire:click="resend"
                class="w-full flex items-center justify-center gap-2 py-3 rounded-xl font-extrabold text-sm transition"
                style="background: #16a3b7; color: white; box-shadow: 0 2px 0 #0e7a8a; font-family: 'Syne', sans-serif;"
                onmouseover="this.style.background='#13919e'"
                onmouseout="this.style.background='#16a3b7'"
            >
                Reenviar email
            </button>

        </div>
    </div>
</div>