<div class="max-w-6xl mx-auto">

    @if (!$company) 
        {{-- TIP --}}
        <div class="flex items-start gap-3 rounded-xl px-4 py-3 mb-6" style="background-color: rgba(250,221,55,0.15); border: 1px solid rgba(250,221,55,0.4);">
            <svg class="w-5 h-5 mt-0.5 shrink-0" style="color: #c4a800;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
            <p class="text-sm" style="color: #7a6800;">
                <strong>Dica:</strong> Campos marcados com <span style="color: #337bbc;" class="font-bold">*</span> são obrigatórios.
            </p>
        </div>            
    @endif    

    <form wire:submit="save" class="space-y-6">

        {{-- CARD: INFORMAÇÕES --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(51,123,188,0.1);">
                    <svg class="w-5 h-5" style="color: #337bbc;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Informações da Empresa</h2>
                    <p class="text-xs" style="color: #87c2c0;">Dados principais da empresa.</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Nome Fantasia --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">
                        Nome Fantasia <span style="color: #337bbc;">*</span>
                    </label>
                    <input
                        type="text"
                        wire:model="alias_name"
                        placeholder="Ex: Náutica Premium"
                        @class([
                            'input-pagbank',

                            'input-pagbank-default'
                                => !$errors->has('alias_name'),

                            'input-pagbank-error input-error'
                                => $errors->has('alias_name'),
                        ])                       
                    >
                    @error('alias_name')
                        <p class="text-xs mt-1" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Razão Social --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">
                        Razão Social
                    </label>
                    <input
                        type="text"
                        wire:model="social_name"
                        placeholder="Ex: Náutica Premium LTDA"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                    >                    
                </div>

                {{-- CNPJ --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">
                        CNPJ
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            wire:model="document_company"
                            placeholder="00.000.000/0001-00"
                            class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                            x-data
                            x-init="
                                let mask = IMask($el, {
                                    mask: [
                                        { mask: '00.000.000/0000-00' },
                                        { mask: '00.000.000/0000-00' }
                                    ]
                                });
                                mask.on('accept', () => {
                                    $el.dispatchEvent(new Event('input'));
                                });
                            "
                        >
                    </div>
                </div>

                {{-- Cadastur --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">
                        Cadastur
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            wire:model="cadastur"
                            placeholder="00.000.000/0001-00"
                            class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                            x-data
                            x-init="
                                let mask = IMask($el, {
                                    mask: [
                                        { mask: '00.000.000/0000-00' },
                                        { mask: '00.000.000/0000-00' }
                                    ]
                                });
                                mask.on('accept', () => {
                                    $el.dispatchEvent(new Event('input'));
                                });
                            "
                        >
                    </div>
                </div>

                {{-- Email --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">
                        E-mail Comercial <span style="color: #337bbc;">*</span>
                    </label>
                    <div class="relative">
                        <input
                            type="email"
                            wire:model="email"
                            placeholder="contato@empresa.com"
                            @class([
                                'input-pagbank',

                                'input-pagbank-default'
                                    => !$errors->has('email'),

                                'input-pagbank-error input-error'
                                    => $errors->has('email'),
                            ])
                        >
                        @error('email')
                            <p class="text-xs mt-1" style="color: #e53e3e;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Email Adicional --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">
                        E-mail Adicional
                    </label>
                    <div class="relative">
                        <input
                            type="email"
                            wire:model="additional_email"
                            placeholder="contato@empresa.com"
                            class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >
                    </div>
                </div>

                {{-- Telefone --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Telefone</label>
                    <div class="relative">
                        <input
                            type="text"
                            wire:model="phone"
                            placeholder="(00) 00000-0000"
                            class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                            x-data
                            x-init="
                                let mask = IMask($el, {
                                    mask: [
                                        { mask: '(00) 0000-0000' },
                                        { mask: '(00) 00000-0000' }
                                    ]
                                });
                                mask.on('accept', () => {
                                    $el.dispatchEvent(new Event('input'));
                                });
                            "
                        >
                    </div>
                </div>

                {{-- WhatsApp --}}
                <div class="flex flex-col gap-1.5">
                <label class="text-sm font-bold" style="color: #051e34;">
                    WhatsApp <span style="color: #337bbc;">*</span>
                </label>
                <div class="relative">
                    <input
                        type="text"
                        wire:model="whatsapp"
                        placeholder="(00) 00000-0000"
                        x-data
                        x-init="$nextTick(() => {
                            IMask($el, {
                                mask: [
                                    { mask: '(00) 0000-0000' },
                                    { mask: '(00) 00000-0000' }
                                ]
                            })
                        })"
                        @class([
                            'input-pagbank',
                            'input-pagbank-default' => !$errors->has('whatsapp'),
                            'input-pagbank-error input-error' => $errors->has('whatsapp'),
                        ])
                    >
                    @error('whatsapp')
                        <p class="text-xs mt-1" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            </div>
        </div>

        {{-- CARD: ENDEREÇO --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(22,163,183,0.1);">
                    <svg class="w-5 h-5" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Endereço</h2>
                    <p class="text-xs" style="color: #87c2c0;">Localização da empresa.</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- CEP --}}
                <div class="flex flex-col gap-1.5" x-ref="zipcode">
                    <label class="text-sm font-bold" style="color: #051e34;">
                        CEP
                    </label>

                    <input
                        type="text"
                        wire:model.lazy="zipcode"
                        placeholder="00000-000"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        x-data
                        x-init="
                            let mask = IMask($el, {
                                mask: [
                                    { mask: '00.000-000' },
                                    { mask: '00.000-000' }
                                ]
                            });
                            mask.on('accept', () => {
                                $el.dispatchEvent(new Event('input'));
                            });
                        "
                    >
                </div>

                {{-- Cidade --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">
                        Cidade
                    </label>

                    <input
                        type="text"
                        wire:model="city"
                        placeholder="São Paulo"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        readonly
                    >
                </div>

                {{-- Estado --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">
                        Estado
                    </label>

                    <input
                        type="text"
                        wire:model="state"
                        placeholder="SP"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        readonly
                    >
                </div>

                {{-- Rua --}}
                <div class="flex flex-col gap-1.5 md:col-span-2">
                    <label class="text-sm font-bold" style="color: #051e34;">
                        Rua
                    </label>

                    <input
                        type="text"
                        wire:model="street"
                        placeholder="Av. Beira Mar"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        readonly
                    >
                </div>

                {{-- Número --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">
                        Número
                    </label>

                    <input
                        type="text"
                        wire:model="number"
                        placeholder="123"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                    >
                </div>

                {{-- Bairro --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">
                        Bairro
                    </label>

                    <input
                        type="text"
                        wire:model="neighborhood"
                        placeholder="Centro"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        readonly
                    >
                </div>

                {{-- Complemento --}}
                <div class="flex flex-col gap-1.5 md:col-span-2">
                    <label class="text-sm font-bold" style="color: #051e34;">
                        Complemento
                    </label>

                    <input
                        type="text"
                        wire:model="complement"
                        placeholder="Sala, bloco, referência..."
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                    >
                </div>

            </div>
        </div>

        {{-- REDES SOCIAIS --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">

                <div
                    class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                    style="background-color: rgba(51,123,188,0.1);"
                >

                    <svg
                        class="w-5 h-5"
                        style="color: #337bbc;"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path d="M17 8h2a2 2 0 012 2v10H3V10a2 2 0 012-2h2"/>
                        <path d="M12 12V3"/>
                        <path d="M8 7l4-4 4 4"/>
                    </svg>

                </div>

                <div>

                    <h2 class="text-sm font-bold" style="color: #051e34;">
                        Redes Sociais
                    </h2>

                    <p class="text-xs" style="color: #87c2c0;">
                        Links para divulgação da empresa.
                    </p>

                </div>

            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- URL --}}
                <div class="flex flex-col gap-1.5">

                    <label class="text-sm font-bold" style="color: #051e34;">
                        Website
                    </label>

                    <div class="relative">

                        <input
                            type="text"
                            wire:model="url"
                            placeholder="https://seusite.com.br"
                            class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >

                    </div>

                </div>

                {{-- FACEBOOK --}}
                <div class="flex flex-col gap-1.5">

                    <label class="text-sm font-bold" style="color: #051e34;">
                        Facebook
                    </label>

                    <div class="relative">

                        <input
                            type="text"
                            wire:model="facebook"
                            placeholder="https://facebook.com/suaempresa"
                            class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >

                    </div>

                </div>

                {{-- INSTAGRAM --}}
                <div class="flex flex-col gap-1.5">

                    <label class="text-sm font-bold" style="color: #051e34;">
                        Instagram
                    </label>

                    <div class="relative">

                        <input
                            type="text"
                            wire:model="instagram"
                            placeholder="https://instagram.com/suaempresa"
                            class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >

                    </div>

                </div>

                {{-- TWITTER --}}
                <div class="flex flex-col gap-1.5">

                    <label class="text-sm font-bold" style="color: #051e34;">
                        Twitter / X
                    </label>

                    <div class="relative">

                        <input
                            type="text"
                            wire:model="twitter"
                            placeholder="https://x.com/suaempresa"
                            class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >

                    </div>

                </div>

                {{-- LINKEDIN --}}
                <div class="flex flex-col gap-1.5">

                    <label class="text-sm font-bold" style="color: #051e34;">
                        LinkedIn
                    </label>

                    <div class="relative">

                        <input
                            type="text"
                            wire:model="linkedin"
                            placeholder="https://linkedin.com/company/suaempresa"
                            class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >

                    </div>

                </div>

                {{-- TIKTOK --}}
                <div class="flex flex-col gap-1.5">

                    <label class="text-sm font-bold" style="color: #051e34;">
                        TikTok
                    </label>

                    <div class="relative">

                        <input
                            type="text"
                            wire:model="tiktok"
                            placeholder="https://tiktok.com/@suaempresa"
                            class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >

                    </div>

                </div>

            </div>

        </div>

        {{-- CARD: IDENTIDADE VISUAL --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(22,163,183,0.1);">
                    <svg class="w-5 h-5" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Identidade Visual</h2>
                    <p class="text-xs" style="color: #87c2c0;">Logo e marca d'água exibidos nas reservas.</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- LOGO --}}
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold" style="color: #051e34;">Logo da Empresa</label>
                    <p class="text-xs" style="color: #87c2c0;">PNG ou JPG, recomendado 400x400px.</p>

                    <label
                        class="flex flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed cursor-pointer transition py-8"
                        style="border-color: #e8e4d8;"
                        onfocus="this.style.borderColor='#16a3b7'"
                        onmouseover="this.style.borderColor='#16a3b7'; this.style.backgroundColor='rgba(22,163,183,0.04)'"
                        onmouseout="this.style.borderColor='#e8e4d8'; this.style.backgroundColor='transparent'"
                    >
                        {{-- Preview --}}
                        @if ($logoPreview)
                            <img src="{{ $logoPreview }}" class="w-48 h-48 object-contain rounded-lg mb-1">
                        @else
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background-color: rgba(22,163,183,0.08);">
                                <svg class="w-7 h-7" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12V3m0 0L8 7m4-4l4 4"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium" style="color: #16a3b7;">Clique para enviar</span>
                            <span class="text-xs" style="color: #b0a98a;">ou arraste o arquivo aqui</span>
                        @endif

                        <input
                            type="file"
                            wire:model="logo"
                            accept="image/png,image/jpeg"
                            class="hidden"
                        >
                    </label>

                    @error('logo')
                        <p class="text-xs mt-1" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- metaimg --}}
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold" style="color: #051e34;">Meta Imagem</label>
                    <p class="text-xs" style="color: #87c2c0;">PNG com fundo transparente, recomendado 800x800px.</p>

                    <label
                        class="flex flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed cursor-pointer transition py-8"
                        style="border-color: #e8e4d8;"
                        onmouseover="this.style.borderColor='#337bbc'; this.style.backgroundColor='rgba(51,123,188,0.04)'"
                        onmouseout="this.style.borderColor='#e8e4d8'; this.style.backgroundColor='transparent'"
                    >
                        {{-- Preview --}}
                        @if ($metaimgPreview)
                            <img src="{{ $metaimgPreview }}" class="w-48 h-48 object-contain rounded-lg mb-1">
                        @else
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background-color: rgba(51,123,188,0.08);">
                                <svg class="w-7 h-7" style="color: #337bbc;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12V3m0 0L8 7m4-4l4 4"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium" style="color: #337bbc;">Clique para enviar</span>
                            <span class="text-xs" style="color: #b0a98a;">ou arraste o arquivo aqui</span>
                        @endif

                        <input
                            type="file"
                            wire:model="metaimg"
                            accept="image/png"
                            class="hidden"
                        >
                    </label>

                    @error('metaimg')
                        <p class="text-xs mt-1" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- CARD: SOBRE --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(35,197,94,0.1);">
                    <svg class="w-5 h-5" style="color: #23c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Sobre a Empresa</h2>
                    <p class="text-xs" style="color: #87c2c0;">Apresente sua operação aos clientes.</p>
                </div>
            </div>

            <div class="p-6">
                <textarea
                    wire:model="content"
                    rows="8"
                    placeholder="Conte um pouco sobre sua operação náutica, diferenciais e serviços oferecidos..."
                    class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                    style="border-color: #e8e4d8; color: #051e34;"
                    onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                    onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                ></textarea>
            </div>

        </div>

        {{-- ACTIONS --}}
        <div class="flex items-center justify-end gap-3 pt-2">

            <button
                type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-extrabold transition"
                style="background-color: #23c55e; color: #ffffff; box-shadow: 0 2px 0 #15803d;"
                onmouseover="this.style.backgroundColor='#1aad52'"
                onmouseout="this.style.backgroundColor='#23c55e'"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                {{ $company->exists ? 'Editar' : 'Salvar' }}
            </button>

        </div>

    </form>

</div>

@push('scripts')
    <script>

        document.addEventListener('livewire:init', () => {
        Livewire.on('scroll-to-error', () => {
            setTimeout(() => {
                const firstError = document.querySelector('.input-error');
                if (!firstError) return;
                const offset = 120;
                const targetPosition =
                    firstError.getBoundingClientRect().top
                    + window.pageYOffset
                    - offset;
                smoothScrollTo(targetPosition, 1200);
                firstError.focus();
            }, 100);
        });
    });

    function smoothScrollTo(target, duration = 1000) {
        const start = window.pageYOffset;
        const distance = target - start;
        let startTime = null;
        function animation(currentTime) {
            if (!startTime) startTime = currentTime;
            const timeElapsed = currentTime - startTime;
            const progress = Math.min(timeElapsed / duration, 1);

            // easeInOutCubic
            const ease =
                progress < 0.5
                    ? 4 * progress * progress * progress
                    : 1 - Math.pow(-2 * progress + 2, 3) / 2;

            window.scrollTo(
                0,
                start + distance * ease
            );

            if (timeElapsed < duration) {
                requestAnimationFrame(animation);
            }
        }
        requestAnimationFrame(animation);
    }
    </script>
@endpush