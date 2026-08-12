<div
    x-data="{ open: @entangle('open') }"
    @click.outside="open = false"
    class="relative w-full"
>

    <div class="relative">
        <svg
            class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24">

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
        </svg>
        <input
            wire:model.live.debounce.300ms="search"
            class="w-full h-12 rounded-2xl border border-slate-200 pl-12 pr-4"
            placeholder="Buscar passeios, empresas ou cidades..."
            autocomplete="off">
    </div>

    {{-- Verificação segura no Blade --}}
    @php
        $results = $this->results;
        $hasResults = count($results['cities'] ?? []) > 0 || 
                    count($results['companies'] ?? []) > 0 || 
                    count($results['tours'] ?? []) > 0;
    @endphp

    @if(strlen($search) >= 2)
        <div x-show="open" class="absolute z-50 w-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
            @if($hasResults)
                <div wire:loading.flex class="p-6 justify-center">
                    Procurando...
                </div>

                <div wire:loading.remove>
                    @if(count($this->results['cities']))
                        <div class="p-4">
                            <h5 class="text-xs uppercase text-gray-500 font-bold mb-3">
                                Cidades
                            </h5>
                            @foreach($this->results['cities'] as $city)
                                <a href="{{ route('web.site.search', ['city' => $city]) }}" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-gray-700 font-medium">{{ $city }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    @if(count($this->results['companies']))
                        <div class="border-t">
                            <div class="p-4">
                                <h5 class="text-xs uppercase text-gray-500 font-bold mb-3">
                                    Operadoras
                                </h5>
                                @foreach($this->results['companies'] as $company)
                                    <a href="{{ route('web.site.company', $company->slug) }}" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                                        <img src="{{ $company->getLogoUrl() }}" class="w-8 h-8 rounded-full object-cover mr-3 border shadow-sm">
                                        <div class="flex flex-col">
                                            <span class="text-gray-800 font-semibold text-sm">{{ $company->alias_name }}</span>
                                            <span class="text-gray-500 text-xs">{{ $company->city }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(count($this->results['tours']))
                        <div class="border-t">
                            <div class="p-4">
                                <h5 class="text-xs uppercase text-gray-500 font-bold mb-3">
                                    Passeios
                                </h5>
                                @foreach($this->results['tours'] as $tour)
                                    <a href="{{ route('web.site.tour', ['slug' => $tour->company->slug, 'uuid' => $tour->uuid]) }}" class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors">
                                        <img src="{{ $tour->cover() }}" class="w-10 h-10 rounded-lg object-cover mr-3 shadow-sm">
                                        <div class="flex flex-col">
                                            <span class="text-gray-800 font-semibold text-sm">{{ $tour->title }}</span>
                                            <span class="text-gray-500 text-xs">{{ $tour->company->name }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif            
                </div>
            @else
                <div class="p-4 text-center text-gray-500">
                    Nenhum resultado encontrado para "{{ $search }}"
                </div>
            @endif
        </div>
    @endif
</div>