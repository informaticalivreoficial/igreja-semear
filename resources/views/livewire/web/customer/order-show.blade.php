<div class="max-w-2xl mx-auto py-8 px-4">

    <div class="flex justify-between items-center mb-6 print:hidden">
        <a href="{{ route('customer.orders.index') }}" class="text-blue-600 font-semibold">← Voltar</a>

        @if($booking->status->value === 'CONFIRMED')
            <a href="{{ route('customer.orders.pdf', $booking->uuid) }}"
                class="bg-blue-600 text-white px-5 py-2 rounded-xl font-semibold inline-flex items-center gap-2">
                Baixar voucher em PDF
            </a>
        @else
            <span class="text-sm text-gray-400 italic">
                Voucher disponível após confirmação do pagamento
            </span>
        @endif
    </div>

    <div id="voucher" class="bg-white rounded-2xl shadow-xl p-8 print:shadow-none print:p-0">
        <div class="flex justify-between items-start border-b pb-4 mb-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $booking->tourDate->tour->title }}</h2>
                <p class="text-gray-500 text-sm">Voucher de reserva</p>
            </div>
           <span class="px-3 py-1 rounded-full text-xs font-semibold
                @switch($booking->status->value)
                    @case('CONFIRMED') bg-green-100 text-green-700 @break
                    @case('CANCELLED') bg-red-100 text-red-700 @break
                    @case('COMPLETED') bg-blue-100 text-blue-700 @break
                    @case('NO_SHOW') bg-gray-200 text-gray-600 @break
                    @default bg-yellow-100 text-yellow-700
                @endswitch">
                {{ $booking->status->label() }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm mb-6">
            <div><span class="text-gray-500">Código</span><br><strong>{{ strtoupper(substr($booking->uuid, 0, 8)) }}</strong></div>
            <div><span class="text-gray-500">Data</span><br><strong>{{ $booking->tourDate->date->format('d/m/Y') }}</strong></div>
            <div><span class="text-gray-500">Horário</span><br><strong>{{ $booking->tourDate->start_time }}</strong></div>
            <div><span class="text-gray-500">Pessoas</span><br><strong>{{ $booking->adults }} adulto(s) @if($booking->children) + {{ $booking->children }} criança(s) @endif</strong></div>
            <div><span class="text-gray-500">Cliente</span><br><strong>{{ $booking->customer_name }}</strong></div>
            <div><span class="text-gray-500">Total pago</span><br><strong>R$ {{ number_format($booking->total, 2, ',', '.') }}</strong></div>
        </div>

        <div class="border-t pt-4 text-xs text-gray-400 text-center">
            Apresente este voucher (impresso ou digital) no dia do passeio.
        </div>
    </div>
</div>

@push('styles')
    <style>
        @media print {
            body * { visibility: hidden; }
            #voucher, #voucher * { visibility: visible; }
            #voucher { position: absolute; top: 0; left: 0; width: 100%; }
        }
    </style>
@endpush