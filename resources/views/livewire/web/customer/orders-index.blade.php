<div class="max-w-3xl mx-auto py-8 px-4">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Meus pedidos</h2>
        <form method="POST" action="{{ route('customer.orders.logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-red-500 font-medium">
                Sair
            </button>
        </form>
    </div>

    @if($bookings->isEmpty())
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <p class="text-gray-500">Você ainda não tem nenhuma reserva.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($bookings as $booking)
                <a href="{{ route('customer.orders.show', $booking->uuid) }}"
                    class="block bg-white rounded-2xl shadow-md hover:shadow-xl p-5 transition-all duration-300">
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <h3 class="font-bold text-gray-800">{{ $booking->tourDate->tour->title }}</h3>
                            <div class="flex gap-4 text-sm text-gray-500 mt-1">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $booking->tourDate->date->format('d/m/Y') }}
                                </span>
                                <span>{{ $booking->adults }} adulto(s) @if($booking->children) + {{ $booking->children }} criança(s) @endif</span>
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                @switch($booking->status->value)
                                    @case('CONFIRMED') bg-green-100 text-green-700 @break
                                    @case('CANCELLED') bg-red-100 text-red-700 @break
                                    @case('COMPLETED') bg-blue-100 text-blue-700 @break
                                    @case('NO_SHOW') bg-gray-200 text-gray-600 @break
                                    @default bg-yellow-100 text-yellow-700
                                @endswitch">
                                {{ $booking->status->label() }}
                            </span>
                            <div class="text-sm font-bold text-gray-800 mt-2">
                                R$ {{ number_format($booking->total, 2, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</div>