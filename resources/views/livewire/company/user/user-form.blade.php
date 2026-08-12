<div class="max-w-6xl mx-auto">

    <form wire:submit="save" class="space-y-6">

        {{-- AVATAR --}}
        <div
            class="bg-white rounded-2xl overflow-hidden"
            style="border: 1px solid #e8e4d8;"
        >

            {{-- HEADER --}}
            <div
                class="flex items-center gap-3 px-6 py-4"
                style="border-bottom: 1px solid #f0ece4;"
            >

                <div
                    class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                    style="background-color: rgba(35,197,94,0.1);"
                >
                    <svg
                        class="w-5 h-5"
                        style="color: #23c55e;"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                </div>

                <div>
                    <h2
                        class="text-sm font-bold"
                        style="color: #051e34;"
                    >
                        Foto de Perfil
                    </h2>

                    <p
                        class="text-xs"
                        style="color: #87c2c0;"
                    >
                        PNG, JPG ou WEBP até 2MB.
                    </p>
                </div>

            </div>

            {{-- BODY --}}
            <div class="p-6">

                <div class="flex flex-col md:flex-row gap-6 items-start">

                    {{-- PREVIEW --}}
                    <div class="relative shrink-0">

                        {{-- NOVA IMAGEM --}}
                        @if ($avatar)

                            <img
                                src="{{ $avatar->temporaryUrl() }}"
                                class="w-28 h-28 rounded-2xl object-cover border-4"
                                style="border-color: #23c55e;"
                            >

                            {{-- REMOVER --}}
                            <button
                                type="button"
                                wire:click="$set('avatar', null)"
                                class="absolute -top-2 -right-2 w-8 h-8 rounded-full flex items-center justify-center shadow-lg transition"
                                style="background-color: #ef4444; color: white;"
                            >
                                ✕
                            </button>

                        {{-- IMAGEM ATUAL --}}
                        @elseif(auth()->user()->avatar)

                            <img
                                src="{{ Storage::url(auth()->user()->avatar) }}"
                                class="w-28 h-28 rounded-2xl object-cover border-4"
                                style="border-color: #e8e4d8;"
                            >

                        {{-- FALLBACK --}}
                        @else

                            <div
                                class="w-28 h-28 rounded-2xl flex items-center justify-center text-4xl font-extrabold border-4"
                                style="
                                    background-color: #23c55e;
                                    color: #051e34;
                                    border-color: #e8e4d8;
                                "
                            >
                                {{ strtoupper(substr($name ?? auth()->user()->name ?? 'U', 0, 1)) }}
                            </div>

                        @endif

                    </div>

                    {{-- INPUT --}}
                    <div class="flex-1 w-full space-y-4">

                        <div>

                            <label
                                class="text-sm font-bold block mb-2"
                                style="color: #051e34;"
                            >
                                Alterar imagem
                            </label>

                            <input
                                type="file"
                                wire:model="avatar"
                                accept="image/png,image/jpeg,image/webp"
                                class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition bg-white"
                                style="
                                    border-color: #e8e4d8;
                                    color: #051e34;
                                "
                            >

                        </div>

                        {{-- LOADING --}}
                        <div
                            wire:loading
                            wire:target="avatar"
                            class="flex items-center gap-2 text-sm"
                            style="color: #16a3b7;"
                        >
                            <svg
                                class="animate-spin h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>

                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                ></path>
                            </svg>

                            Carregando imagem...
                        </div>

                        {{-- VALIDATION --}}
                        @error('avatar')
                            <div
                                class="rounded-xl px-4 py-3 text-sm"
                                style="
                                    background-color: rgba(239,68,68,0.08);
                                    border: 1px solid rgba(239,68,68,0.2);
                                    color: #dc2626;
                                "
                            >
                                {{ $message }}
                            </div>
                        @enderror

                        {{-- HELP --}}
                        <div
                            class="rounded-xl px-4 py-3 text-xs"
                            style="
                                background-color: rgba(22,163,183,0.06);
                                border: 1px solid rgba(22,163,183,0.12);
                                color: #0f766e;
                            "
                        >
                            Recomendado utilizar uma imagem quadrada de pelo menos
                            300x300 pixels.
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- DADOS PESSOAIS --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(51,123,188,0.1);">
                    <svg class="w-5 h-5" style="color: #337bbc;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Dados Pessoais</h2>
                    <p class="text-xs" style="color: #87c2c0;">Informações de identificação.</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Nome --}}
                <div class="flex flex-col gap-1.5 md:col-span-2">
                    <label class="text-sm font-bold" style="color: #051e34;">Nome Completo <span style="color: #337bbc;">*</span></label>
                    <input type="text" wire:model="name" placeholder="Seu nome completo"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    @error('name') <p class="text-xs" style="color:#e53e3e;">{{ $message }}</p> @enderror
                </div>

                {{-- Gênero --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Gênero</label>
                    <select wire:model="gender"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                        <option value="">Selecione...</option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                        <option value="O">Outro</option>
                        <option value="N">Prefiro não informar</option>
                    </select>
                </div>

                {{-- Estado Civil --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Estado Civil</label>
                    <select wire:model="civil_status"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                        <option value="">Selecione...</option>
                        <option value="solteiro">Solteiro(a)</option>
                        <option value="casado">Casado(a)</option>
                        <option value="divorciado">Divorciado(a)</option>
                        <option value="viuvo">Viúvo(a)</option>
                        <option value="uniao_estavel">União Estável</option>
                    </select>
                </div>

                {{-- CPF --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">CPF</label>
                    <div class="relative">
                        <input type="text" wire:model="cpf" placeholder="000.000.000-00"
                            @class([
                                'input-pagbank',
                                'input-pagbank-default' => !$errors->has('cpf'),
                                'input-pagbank-error input-error' => $errors->has('cpf'),
                            ])
                            x-data
                            x-init="
                                let mask = IMask($el, {
                                    mask: [
                                        { mask: '000.000.000-00' },
                                        { mask: '000.000.000-00' }
                                    ]
                                });
                                mask.on('accept', () => {
                                    $el.dispatchEvent(new Event('input'));
                                });
                            "
                        >
                        @error('cpf')
                        <p
                            class="text-xs mt-1"
                            style="color: #e53e3e;"
                        >
                            {{ $message }}
                        </p>
                    @enderror
                    </div>
                </div>

                {{-- RG --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">RG</label>
                    <input type="text" wire:model="rg" placeholder="00.000.000-0"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

                {{-- Nascimento --}}
                <div class="flex flex-col gap-1.5">

                    <label class="text-sm font-bold" style="color: #051e34;">
                        Data de Nascimento
                    </label>

                    <div
                        wire:ignore
                        x-data
                        x-init="
                            flatpickr($refs.birthday, {
                                locale: FlatpickrPortuguese,
                                dateFormat: 'd/m/Y',
                                maxDate: 'today',
                                allowInput: true,
                                defaultDate: @js($birthday),
                                onChange: function(selectedDates, dateStr) {
                                    $wire.set('birthday', dateStr);
                                }
                            });
                        "
                    >

                        <input
                            x-ref="birthday"
                            type="text"
                            placeholder="Selecione a data"
                            class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >

                    </div>

                    @error('birthday')
                        <p class="text-xs mt-1" style="color:#e53e3e;">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                {{-- Naturalidade --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Naturalidade</label>
                    <input type="text" wire:model="naturalness" placeholder="Cidade onde nasceu"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

            </div>
        </div>

        {{-- CONTATO --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(22,163,183,0.1);">
                    <svg class="w-5 h-5" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8 19.79 19.79 0 01.22 2.18 2 2 0 012.18 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.91a16 16 0 006.29 6.29l1.28-1.28a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Contato</h2>
                    <p class="text-xs" style="color: #87c2c0;">E-mails, telefones e mensageiros.</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-bold mb-1.5" style="color: #051e34;">E-mail</label>
                    <input
                        type="email"
                        value="{{ auth('customer')->user()->email }}"
                        class="w-full h-11 px-4 rounded-2xl text-sm"
                        style="border: 1.5px solid #e8e4d8; color: #87c2c0; background: #fafaf8;"
                        readonly
                    >
                    <p class="text-xs mt-1" style="color: #c5bfb2;">
                        Para alterar o e-mail entre em contato com o suporte.
                    </p>
                </div>

                {{-- Email adicional --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">E-mail de recuperação</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <input type="email" wire:model="additional_email" placeholder="outro@email.com"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Telefone --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Telefone</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8 19.79 19.79 0 01.22 2.18 2 2 0 012.18 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.91a16 16 0 006.29 6.29l1.28-1.28a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                        <input type="text" wire:model="phone" placeholder="(00) 0000-0000"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                            x-data
                            x-init="
                                let mask = IMask($el, {
                                    mask: [
                                        { mask: '(00) 0000-0000' },
                                        { mask: '(00) 0000-0000' }
                                    ]
                                });
                                mask.on('accept', () => {
                                    $el.dispatchEvent(new Event('input'));
                                });
                            "
                        >
                    </div>
                </div>

                {{-- Celular --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Celular</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                        <input type="text" wire:model="cell_phone" placeholder="(00) 00000-0000"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                            x-data
                            x-init="
                                let mask = IMask($el, {
                                    mask: [
                                        { mask: '(00) 00000-0000' },
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
                    <label class="text-sm font-bold" style="color: #051e34;">WhatsApp</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                        <input type="text" wire:model="whatsapp" placeholder="(00) 00000-0000"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                            x-data
                            x-init="
                                let mask = IMask($el, {
                                    mask: [
                                        { mask: '(00) 00000-0000' },
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

                {{-- Telegram --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Telegram</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        <input type="text" wire:model="telegram" placeholder="@usuario"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

            </div>
        </div>

        {{-- ENDEREÇO --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(22,163,183,0.1);">
                    <svg class="w-5 h-5" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Endereço</h2>
                    <p class="text-xs" style="color: #87c2c0;">Localização residencial.</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-5">

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">CEP</label>
                    <input type="text" wire:model.lazy="zipcode" placeholder="00.000-000"
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

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Cidade</label>
                    <input type="text" wire:model="city"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'" readonly>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Estado</label>
                    <input type="text" wire:model="state"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'" readonly>
                </div>

                <div class="flex flex-col gap-1.5 md:col-span-2">
                    <label class="text-sm font-bold" style="color: #051e34;">Rua</label>
                    <input type="text" wire:model="street"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'" readonly>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Número</label>
                    <input type="text" wire:model="number" placeholder="123"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Bairro</label>
                    <input type="text" wire:model="neighborhood"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'" readonly>
                </div>

                <div class="flex flex-col gap-1.5 md:col-span-2">
                    <label class="text-sm font-bold" style="color: #051e34;">Complemento</label>
                    <input type="text" wire:model="complement" placeholder="Apto 42, Bloco B"
                        class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34;"
                        onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                        onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                </div>

            </div>
        </div>

        {{-- REDES SOCIAIS --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(250,221,55,0.15);">
                    <svg class="w-5 h-5" style="color: #c4a800;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Redes Sociais</h2>
                    <p class="text-xs" style="color: #87c2c0;">Seus perfis nas redes.</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Instagram --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Instagram</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold pointer-events-none" style="color: #87c2c0;">@</span>
                        <input type="text" wire:model="instagram" placeholder="seu_usuario"
                            class="w-full border rounded-xl text-sm pl-7 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Facebook --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Facebook</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold pointer-events-none" style="color: #87c2c0;">f/</span>
                        <input type="text" wire:model="facebook" placeholder="seu.perfil"
                            class="w-full border rounded-xl text-sm pl-8 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- Twitter / X --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Twitter / X</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold pointer-events-none" style="color: #87c2c0;">@</span>
                        <input type="text" wire:model="twitter" placeholder="seu_usuario"
                            class="w-full border rounded-xl text-sm pl-7 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

                {{-- LinkedIn --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">LinkedIn</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold pointer-events-none" style="color: #87c2c0;">in/</span>
                        <input type="text" wire:model="linkedin" placeholder="seu-perfil"
                            class="w-full border rounded-xl text-sm pl-8 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

            </div>
        </div>

        {{-- SENHA --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(51,123,188,0.1);">
                    <svg class="w-5 h-5" style="color: #337bbc;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Senha</h2>
                    <p class="text-xs" style="color: #87c2c0;">Deixe em branco para manter a atual.</p>
                </div>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Nova Senha</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <input type="password" wire:model="password" placeholder="••••••••"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                    @error('password') <p class="text-xs" style="color:#e53e3e;">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Confirmar Senha</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <input type="password" wire:model="password_confirmation" placeholder="••••••••"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'">
                    </div>
                </div>

            </div>
        </div>

        {{-- SOBRE 
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(35,197,94,0.1);">
                    <svg class="w-5 h-5" style="color: #23c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Sobre Você</h2>
                    <p class="text-xs" style="color: #87c2c0;">Uma breve apresentação.</p>
                </div>
            </div>

            <div class="p-6">
                <textarea wire:model="information" rows="4"
                    placeholder="Conte um pouco sobre você..."
                    class="w-full border rounded-xl text-sm px-3 py-2.5 outline-none transition"
                    style="border-color: #e8e4d8; color: #051e34;"
                    onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                    onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"></textarea>
            </div>

        </div>--}}

        {{-- ACTIONS --}}
        <div class="flex items-center justify-end gap-3 pt-2">

            <a
                href="{{ route('company.tours.index') }}"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition"
                style="border: 1px solid #e8e4d8; background: #cccccc; color: #051e34;"
                onmouseover="this.style.backgroundColor='#dddddd'"
                onmouseout="this.style.backgroundColor='#cccccc'"
            >
                Cancelar
            </a>

            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-extrabold transition"
                style="background-color: #23c55e; color: #ffffff; box-shadow: 0 2px 0 #15803d;"
                onmouseover="this.style.backgroundColor='#1aad52'"
                onmouseout="this.style.backgroundColor='#23c55e'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Salvar Alterações
            </button>

        </div>

    </form>

</div>