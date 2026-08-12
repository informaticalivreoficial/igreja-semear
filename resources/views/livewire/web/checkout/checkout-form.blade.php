{{-- resources/views/livewire/booking-form-improved.blade.php --}}
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8 px-4">
    <div class="max-w-2xl mx-auto">
        
        {{-- Header com gradiente --}}
        <div class="text-center mb-8">
            <img class="h-20 w-auto mx-auto" src="{{ $config->getlogo() }}" alt="{{ $config->app_name }}">
            <p class="text-gray-500 mt-2">Complete sua reserva em 3 passos!</p>
        </div>

        {{-- Progress Bar Animada --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                @foreach(['Resumo', 'Seus dados', 'Pagamento'] as $index => $stepName)
                    <div class="flex items-center {{ $index < 2 ? 'flex-1' : '' }}">
                        {{-- Círculo do step --}}
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 
                                {{ $step > $index + 1 ? 'bg-green-500' : ($step === $index + 1 ? 'bg-blue-600' : 'bg-gray-200') }}">
                                @if($step > $index + 1)
                                    {{-- Check icon --}}
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    <span class="text-sm font-semibold {{ $step === $index + 1 ? 'text-white' : 'text-gray-500' }}">
                                        {{ $index + 1 }}
                                    </span>
                                @endif
                            </div>
                            <span class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 text-xs font-medium
                                {{ $step >= $index + 1 ? 'text-blue-600' : 'text-gray-400' }} whitespace-nowrap">
                                {{ $stepName }}
                            </span>
                        </div>
                        
                        {{-- Linha de conexão --}}
                        @if($index < 2)
                            <div class="flex-1 h-1 mx-2 rounded transition-all duration-300
                                {{ $step > $index + 1 ? 'bg-green-500' : ($step === $index + 1 ? 'bg-blue-200' : 'bg-gray-200') }}">
                                @if($step > $index + 1)
                                    <div class="h-full bg-green-500 rounded animate-pulse"></div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Card do Tour com Gradiente --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6 transform transition-all duration-300 hover:shadow-2xl">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                        <img class="w-16 h-16 object-cover rounded-lg" 
                            src="{{ $tourDate->tour->cover() }}" 
                            alt="{{ $tourDate->tour->title }}">
                    </div>
                    <div class="text-white">
                        <h2 class="font-bold text-lg">{{ $tourDate->tour->title }}</h2>
                        <div class="flex gap-4 text-sm text-blue-100">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $tourDate->date->format('d/m/Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $tourDate->start_time }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-auto text-right">
                        <div class="text-2xl font-bold text-white">R$ {{ number_format($total, 2, ',', '.') }}</div>
                        <div class="text-xs text-blue-100">total</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STEP 1: Resumo/Quantidades --}}
        @if($step === 1)
            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Quantas pessoas?
                </h3>

                {{-- Adultos --}}
                <div class="bg-gradient-to-r from-blue-50 to-white p-4 rounded-xl mb-4 border border-blue-100 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Adultos
                            </div>
                            <div class="text-sm text-gray-500 mt-1">R$ {{ number_format($tourDate->price, 2, ',', '.') }} por pessoa</div>
                        </div>
                        <div class="flex items-center gap-4">
                            <button wire:click="$set('adults', {{ max(1, $adults - 1) }})" 
                                class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-blue-400 hover:bg-blue-50 
                                    flex items-center justify-center text-gray-600 hover:text-blue-600 transition-all duration-200">
                                −
                            </button>
                            <span class="text-xl font-bold text-gray-800 min-w-[2rem] text-center">{{ $adults }}</span>
                            <button wire:click="$set('adults', {{ $adults + 1 }})"
                                class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 
                                    text-white flex items-center justify-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                +
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Crianças (se houver meia entrada) --}}
                @if($tourDate->half_price)
                    <div class="bg-gradient-to-r from-orange-50 to-white p-4 rounded-xl mb-6 border border-orange-200 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                                    </svg>
                                    Crianças
                                    <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded-full font-medium">meia entrada</span>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">R$ {{ number_format($tourDate->half_price, 2, ',', '.') }} por criança</div>
                            </div>
                            <div class="flex items-center gap-4">
                                <button wire:click="$set('children', {{ max(0, $children - 1) }})"
                                    class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-orange-400 hover:bg-orange-50 
                                        flex items-center justify-center text-gray-600 hover:text-orange-600 transition-all duration-200">
                                    −
                                </button>
                                <span class="text-xl font-bold text-gray-800 min-w-[2rem] text-center">{{ $children }}</span>
                                <button wire:click="$set('children', {{ $children + 1 }})"
                                    class="w-10 h-10 rounded-lg bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 
                                        text-white flex items-center justify-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Vagas disponíveis --}}
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl mb-6 border border-green-200">
                    <div class="flex items-center gap-2 text-green-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">{{ $tourDate->available_slots }} vagas disponíveis nesta data</span>
                    </div>
                </div>

                @error('adults') 
                    <div class="text-red-500 text-sm mb-4">{{ $message }}</div>
                @enderror

                <div class="flex gap-3 mt-8">
                    <button onclick="window.history.back()"
                        class="flex-1 border-2 border-gray-200 hover:border-blue-400 text-gray-600 hover:text-blue-600 
                            font-semibold py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Voltar
                    </button>
                    <button wire:click="nextStep"
                        class="flex-[2] bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 
                            text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-xl 
                            transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2">
                        Continuar
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>                
            </div>
        @endif

        {{-- STEP 2: Dados do Cliente --}}
        @if($step === 2)
            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                    </svg>
                    Seus dados
                </h3>

                {{-- Inputs com ícones contextuais --}}
                <div class="space-y-5">
                    {{-- Nome --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome completo <span class="text-red-500">*</span>
                        </label>
                        <input
                            wire:model.live="name"
                            type="text"
                            placeholder="Como está no documento"
                            class="w-full px-4 py-3 rounded-xl border-2 outline-none transition-all duration-300
                                @error('name') border-red-400 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-200
                                @else border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 @enderror"
                        >
                        @error('name')
                            <div class="flex items-center gap-1.5 mt-1.5">
                                <svg class="w-3.5 h-3.5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            E-mail <span class="text-red-500">*</span>
                        </label>
                        <input
                            wire:model.live="email"
                            type="email"
                            placeholder="seu@email.com"
                            class="w-full px-4 py-3 rounded-xl border-2 outline-none transition-all duration-300
                                @error('email') border-red-400 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-200
                                @else border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 @enderror"
                        >
                        @error('email')
                            <div class="flex items-center gap-1.5 mt-1.5">
                                <svg class="w-3.5 h-3.5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    {{-- Telefone --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Telefone / WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input
                            wire:model.live="phone"
                            type="tel"
                            placeholder="(00) 00000-0000"
                            x-mask="(99) 99999-9999"
                            class="w-full px-4 py-3 rounded-xl border-2 outline-none transition-all duration-300
                                @error('phone') border-red-400 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-200
                                @else border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 @enderror"
                        >
                        @error('phone')
                            <div class="flex items-center gap-1.5 mt-1.5">
                                <svg class="w-3.5 h-3.5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    {{-- CPF --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            CPF <span class="text-red-500">*</span>
                        </label>
                        <input
                            wire:model.live="cpf"
                            type="text"
                            placeholder="000.000.000-00"
                            x-mask="999.999.999-99"
                            class="w-full px-4 py-3 rounded-xl border-2 outline-none transition-all duration-300
                                @error('cpf') border-red-400 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-200
                                @else border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 @enderror"
                        >
                        @error('cpf')
                            <div class="flex items-center gap-1.5 mt-1.5">
                                <svg class="w-3.5 h-3.5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-3 mt-8">
                    <button wire:click="prevStep"
                        class="flex-1 border-2 border-gray-200 hover:border-blue-400 text-gray-600 hover:text-blue-600 
                            font-semibold py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Voltar
                    </button>
                    <button wire:click="nextStep"
                        class="flex-[2] bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 
                            text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-xl 
                            transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2">
                        Continuar para pagamento
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- STEP 3: Pagamento --}}
        @if($step === 3)
            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Forma de pagamento
                </h3>

                {{-- Métodos de pagamento --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    {{-- PIX --}}
                    <button wire:click="$set('paymentMethod', 'pix')"
                        class="p-4 rounded-xl border-2 transition-all duration-300 
                            {{ $paymentMethod === 'pix' ? 'border-green-500 bg-green-50 shadow-lg' : 'border-gray-200 hover:border-green-300' }}">
                        <div class="text-center">
                            <div class="w-12 h-12 mx-auto mb-2 rounded-lg bg-green-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" viewBox="0 0 512 512" fill="currentColor">
                                    <path d="M242.4 292.5C247.8 287.1 257.1 287.1 262.5 292.5L339.5 369.5C357.6 387.6 387.4 387.6 405.5 369.5L412.5 362.5L331.5 281.5C313.4 263.4 313.4 233.6 331.5 215.5L412.5 134.5L405.5 127.5C387.4 109.4 357.6 109.4 339.5 127.5L262.5 204.5C257.1 209.9 247.8 209.9 242.4 204.5L165.5 127.5C147.4 109.4 117.6 109.4 99.5 127.5L92.5 134.5L173.5 215.5C191.6 233.6 191.6 263.4 173.5 281.5L92.5 362.5L99.5 369.5C117.6 387.6 147.4 387.6 165.5 369.5L242.4 292.5z"/>
                                </svg>
                            </div>
                            <div class="font-semibold text-gray-800">PIX</div>
                            <div class="text-xs text-gray-500">Aprovação imediata</div>
                        </div>
                    </button>

                    {{-- Cartão --}}
                    <button wire:click="$set('paymentMethod', 'card')"
                        class="p-4 rounded-xl border-2 transition-all duration-300 
                            {{ $paymentMethod === 'card' ? 'border-blue-500 bg-blue-50 shadow-lg' : 'border-gray-200 hover:border-blue-300' }}">
                        <div class="text-center">
                            <div class="w-12 h-12 mx-auto mb-2 rounded-lg bg-blue-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="1" y="4" width="22" height="16" rx="2"/>
                                    <path d="M1 10h22"/>
                                </svg>
                            </div>
                            <div class="font-semibold text-gray-800">Cartão</div>
                            <div class="text-xs text-gray-500">Crédito ou débito</div>
                        </div>
                    </button>
                </div>

                {{-- Formulário cartão --}}                
                @if($paymentMethod === 'card')
                    <div
                        x-data="mercadoPagoCheckout()"
                        x-init="init()"
                        x-effect="update($wire.total)"
                    >                        
                        <form id="mp-card-form" class="mt-6 space-y-4" wire:ignore>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Número do cartão</label>
                                <div id="cardNumber" style="height: 40px; border: 2px solid #e5e7eb; border-radius: 12px; padding: 4px 8px;"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Vencimento</label>
                                    <div id="expirationDate" style="height: 40px; border: 2px solid #e5e7eb; border-radius: 12px; padding: 4px 8px;"></div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">CVV</label>
                                    <div id="securityCode" style="height: 40px; border: 2px solid #e5e7eb; border-radius: 12px; padding: 4px 8px;"></div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nome no cartão</label>
                                <input
                                    type="text"
                                    id="cardholderName"
                                    placeholder="Nome como está no cartão"
                                    style="height: 40px; border: 2px solid #e5e7eb; border-radius: 12px; padding: 4px 12px; width: 100%; outline: none;"
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Banco emissor</label>
                                <select id="issuer" style="height: 40px; border: 2px solid #e5e7eb; border-radius: 12px; padding: 4px 8px; width: 100%;"></select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Parcelas</label>
                                <select id="installments" style="height: 40px; border: 2px solid #e5e7eb; border-radius: 12px; padding: 4px 8px; width: 100%;"></select>
                            </div>

                            <template x-if="errors.length">
                                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
                                    <ul class="list-disc list-inside text-sm text-red-700">
                                        <template x-for="(error, index) in errors" :key="index">
                                            <li x-text="error"></li>
                                        </template>
                                    </ul>
                                </div>
                            </template>

                            <button
                                type="submit"
                                :disabled="processing"
                                class="w-full bg-gradient-to-r from-green-500 to-emerald-600
                                    hover:from-green-600 hover:to-emerald-700
                                    text-white font-bold py-3 rounded-xl shadow-lg
                                    hover:shadow-xl transition-all duration-300
                                    flex items-center justify-center gap-2
                                    disabled:opacity-50 disabled:cursor-not-allowed">

                                <template x-if="!processing">
                                    <span class="flex items-center gap-2">
                                        Pagar Agora

                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </span>
                                </template>

                                <template x-if="processing">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-5 h-5 animate-spin"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24">
                                            <circle cx="12"
                                                    cy="12"
                                                    r="10"
                                                    stroke="currentColor"
                                                    stroke-width="4"
                                                    class="opacity-25"/>
                                            <path fill="currentColor"
                                                class="opacity-75"
                                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
                                        </svg>

                                        Processando pagamento...
                                    </span>
                                </template>
                            </button>
                        </form>
                    </div>
                @endif
                

                {{-- Total --}}
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl mb-6 mt-6">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total a pagar</span>
                        <span class="text-2xl font-bold text-blue-600">R$ {{ number_format($total, 2, ',', '.') }}</span>
                    </div>
                </div>

                @if($errorMsg)
                    <div class="bg-red-50 border border-red-200 p-4 rounded-xl mb-6 text-red-600">
                        {{ $errorMsg }}
                    </div>
                @endif

                <div class="flex gap-3">
                    <button wire:click="prevStep"
                        class="flex-1 border-2 border-gray-200 hover:border-blue-400 text-gray-600 hover:text-blue-600 
                            font-semibold py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Voltar
                    </button>
                    @if ($paymentMethod === 'pix')
                        <button wire:click="pay" wire:loading.attr="disabled"
                            class="flex-[2] bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 
                                text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-xl 
                                transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2
                                disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="pay">
                                Gerar QR Code PIX
                            </span>
                            <span wire:loading wire:target="pay">Processando...</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    @endif                    
                </div>
            </div>
        @endif

        {{-- STEP 4: Confirmação PIX --}}
        @if($step === 4 && $pixData)
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center"
                wire:poll.5s="checkPixStatus">

                {{-- Header --}}
                <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center animate-pulse"
                    style="background: rgba(34,197,94,0.1);">
                    <svg class="w-8 h-8 text-green-500" viewBox="0 0 512 512" fill="currentColor">
                        <path d="M242.4 292.5C247.8 287.1 257.1 287.1 262.5 292.5L339.5 369.5C357.6 387.6 387.4 387.6 405.5 369.5L412.5 362.5L331.5 281.5C313.4 263.4 313.4 233.6 331.5 215.5L412.5 134.5L405.5 127.5C387.4 109.4 357.6 109.4 339.5 127.5L262.5 204.5C257.1 209.9 247.8 209.9 242.4 204.5L165.5 127.5C147.4 109.4 117.6 109.4 99.5 127.5L92.5 134.5L173.5 215.5C191.6 233.6 191.6 263.4 173.5 281.5L92.5 362.5L99.5 369.5C117.6 387.6 147.4 387.6 165.5 369.5L242.4 292.5z"/>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-1">Aguardando pagamento</h3>
                <p class="text-sm text-gray-500 mb-6">Escaneie o QR Code ou copie o código PIX</p>

                {{-- QR Code --}}
                @if($pixData['qr_code_base64'])
                    <div class="inline-block p-4 rounded-2xl mb-6" style="border: 2px solid #e8e4d8;">
                        <img
                            src="data:image/png;base64,{{ $pixData['qr_code_base64'] }}"
                            class="w-48 h-48 mx-auto"
                            alt="QR Code PIX"
                        >
                    </div>
                @endif

                {{-- Código copia e cola --}}
                <div
                    x-data="{
                        copied: false,
                        copy(text) {
                            if (navigator.clipboard && window.isSecureContext) {
                                navigator.clipboard.writeText(text);
                            } else {
                                const textarea = document.createElement('textarea');
                                textarea.value = text;
                                document.body.appendChild(textarea);
                                textarea.select();
                                document.execCommand('copy');
                                textarea.remove();
                            }

                            this.copied = true;
                            setTimeout(() => this.copied = false, 2000);
                        }
                    }"
                    class="flex items-center gap-2"
                >
                    <code class="flex-1 text-xs text-gray-600 break-all text-left leading-relaxed">
                        {{ $pixData['qr_code'] }}
                    </code>

                    <button
                        @click="copy(@js($pixData['qr_code']))"
                        class="shrink-0 px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 bg-gray-800 text-white"
                        :class="copied ? 'bg-green-500' : 'bg-gray-800'"
                    >
                        <span x-show="!copied">Copiar</span>
                        <span x-show="copied">✓ Copiado!</span>
                    </button>
                </div>

                {{-- Total --}}
                <div class="flex items-center justify-center gap-2 mb-6">
                    <span class="text-gray-500 text-sm">Total:</span>
                    <span class="text-2xl font-bold" style="color: var(--navy);">
                        R$ {{ number_format($total, 2, ',', '.') }}
                    </span>
                </div>

                {{-- Timer --}}
                <div x-data="pixTimer(30)"
                    x-init="start()"
                    class="mb-6">
                    <div class="flex items-center justify-center gap-2 text-sm text-gray-500 mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 6v6l4 2"/>
                        </svg>
                        Expira em <span class="font-semibold text-red-500" x-text="timeLeft"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full transition-all duration-1000"
                            style="background: var(--teal);"
                            :style="`width: ${progress}%`">
                        </div>
                    </div>
                </div>

                {{-- Aguardando --}}
                <div class="flex items-center justify-center gap-2 text-sm" style="color: #87c2c0;">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Verificando pagamento automaticamente...
                </div>

            </div>
        @endif

        {{-- STEP 5: Sucesso --}}
        @if($step === 5)
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

                <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center"
                    style="background: rgba(34,197,94,0.1);">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-2">Reserva confirmada!</h3>
                <p class="text-gray-500 mb-6">
                    Você receberá a confirmação no e-mail <strong>{{ $email }}</strong>
                </p>

                <div class="bg-gray-50 rounded-xl p-5 mb-6 text-left" style="border: 1px solid #e8e4d8;">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-500">Passeio</span>
                        <span class="font-semibold" style="color: var(--navy);">{{ $tourDate->tour->title }}</span>
                    </div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-500">Data</span>
                        <span class="font-semibold" style="color: var(--navy);">{{ $tourDate->date->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-500">Horário</span>
                        <span class="font-semibold" style="color: var(--navy);">{{ $tourDate->start_time }}</span>
                    </div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-500">Pessoas</span>
                        <span class="font-semibold" style="color: var(--navy);">
                            {{ $adults }} adulto(s)
                            @if($children > 0) + {{ $children }} criança(s) @endif
                        </span>
                    </div>
                    <div class="flex justify-between text-sm pt-3 mt-3" style="border-top: 1px solid #e8e4d8;">
                        <span class="font-semibold text-gray-700">Total pago</span>
                        <span class="font-bold text-lg" style="color: var(--navy);">R$ {{ number_format($total, 2, ',', '.') }}</span>
                    </div>
                </div>

                <a href="{{ route('web.home') }}"
                class="inline-flex items-center gap-2 px-8 py-3 rounded-xl font-semibold text-white transition"
                style="background: var(--navy, #0f172a);">
                    Voltar ao início
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>

            </div>
        @endif

    </div>
</div>

@push('scripts')
<script src="https://sdk.mercadopago.com/js/v2"></script>

<script>
function mercadoPagoCheckout() {
    let mpInstance = null;
    let cardFormInstance = null;

    return {
        lastTotal: null,
        processing: false,
        errors: [],

        init() {
            // Inicializa o MP
            mpInstance = new MercadoPago(
                '{{ config("services.mercadopago.public_key") }}',
                { locale: 'pt-BR' }
            );

            // Escuta o evento global do Livewire para destruir o form
            window.addEventListener('mercadopago:destroy', () => {
                this.destroy();
            });
            
            // Também escuta o evento específico do componente (mais robusto)
            this.$wire.on('mercadopago:destroy', () => {
                this.destroy();
            });
        },

        update(total) {
            if (this.lastTotal === total && cardFormInstance) {
                return;
            }
            this.lastTotal = total;
            this.$nextTick(() => {
                this.mount(total);
            });
        },

        mount(total) {
            const form = document.getElementById('mp-card-form');
            if (!form) return;

            this.destroy();

            cardFormInstance = mpInstance.cardForm({
                amount: String(total),
                iframe: true,
                form: {
                    id: "mp-card-form",
                    cardNumber: { id: "cardNumber", placeholder: "Número do cartão" },
                    expirationDate: { id: "expirationDate", placeholder: "MM/AA" },
                    securityCode: { id: "securityCode", placeholder: "CVV" },
                    cardholderName: { id: "cardholderName", placeholder: "Nome impresso no cartão" },
                    issuer: { id: "issuer" },
                    installments: { id: "installments" }
                },
                callbacks: {
                    onFormMounted: (error) => {
                        if (error) console.error(error);
                    },

                    // 👇 NOVO: aqui é onde os erros de token realmente aparecem
                    onCardTokenReceived: (error, token) => {
                        if (error) {
                            //console.error("Erro ao gerar token do cartão:", error);

                            if (Array.isArray(error)) {
                                this.errors = error.map(e => this.translateError(e));
                            } else {
                                this.errors = ['Verifique os dados do cartão e tente novamente.'];
                            }

                            this.processing = false; // libera o botão, já que o submit não vai adiante
                        }
                    },

                    onSubmit: async (event) => {
                        event.preventDefault();

                        this.errors = [];

                        if (this.processing) {
                            return;
                        }

                        this.processing = true;

                        try {
                            const formData = cardFormInstance.getCardFormData();

                            const { token, paymentMethodId, installments } = formData;

                            if (!token || !paymentMethodId) {
                                this.processing = false;
                                return;
                            }

                            await this.$wire.pay({
                                cardToken: token,
                                paymentMethodId: paymentMethodId,
                                installments: Number(installments) || 1,
                            });

                            // 👇 O PHP captura erros de pagamento (cartão recusado, bandeira não
                            // identificada, etc) internamente e preenche $this->errorMsg,
                            // em vez de lançar exceção pro JS. Sem essa checagem, o botão
                            // nunca sai de "Processando..." nesses casos.
                            if (this.$wire.errorMsg) {
                                this.errors = [this.$wire.errorMsg];
                                this.processing = false;
                                return;
                            }

                            if (this.$wire.step === 5) {
                                this.destroy();
                            }

                            this.processing = false;

                        } catch (e) {
                            if (Array.isArray(e)) {
                                this.errors = e.map(error => this.translateError(error));
                            } else {
                                this.errors = ['Não foi possível processar os dados do cartão.'];
                            }
                            this.processing = false;
                        }
                    }
                }
            });
        },

        translateError(error) {
            const fieldMessages = {
                cardNumber: 'Informe um número de cartão válido.',
                securityCode: 'Informe um código de segurança válido.',
                expirationDate: 'Informe uma data de validade válida.',
                expirationMonth: 'Informe o mês de validade.',
                expirationYear: 'Informe o ano de validade.',
                cardholderName: 'Informe o nome impresso no cartão.',
            };

            const codeMessages = {
                '221': 'Informe o nome impresso no cartão.',
                '224': 'Informe um código de segurança válido.',
                '225': 'Informe a data de validade do cartão.',
                '226': 'Informe um número de cartão válido.',
            };

            if (error.field && fieldMessages[error.field]) {
                return fieldMessages[error.field];
            }

            if (error.code && codeMessages[error.code]) {
                return codeMessages[error.code];
            }

            return error.message; 
        },

        destroy() {
            if (cardFormInstance) {
                try {
                    cardFormInstance.unmount();
                } catch (e) {
                    console.warn("Erro ao desmontar CardForm:", e);
                }
                cardFormInstance = null;
                console.log("CardForm destruído.");
            }
        }
    }
}
</script>
<script>
    function pixTimer(minutes) {
        return {
            total: minutes * 60,
            remaining: minutes * 60,
            progress: 100,
            interval: null,

            start() {
                this.interval = setInterval(() => {
                    this.remaining--;
                    this.progress = (this.remaining / this.total) * 100;
                    if (this.remaining <= 0) {
                        clearInterval(this.interval);
                    }
                }, 1000);
            },

            get timeLeft() {
                const m = Math.floor(this.remaining / 60);
                const s = this.remaining % 60;
                return `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
            }
        }
    }
</script>
@endpush