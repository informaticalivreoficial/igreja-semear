@component('mail::layout')

    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
        @endcomponent
    @endslot

    {{-- Body --}}
    <div style="width:100%;">
        <div style="background:#076134; overflow:hidden; padding:15px;">
            <div style="font:16px Trebuchet MS, Arial, Helvetica, sans-serif; color:#fff; font-weight:bold;">
                Resposta ao seu pedido de oração
            </div>
        </div>
        <div style="background:#FFF; font:16px Trebuchet MS, Arial, Helvetica, sans-serif; color:#333; line-height:180%; padding:10px 0;">
            <p>
                Olá, <strong>{{ $data['reply_name'] }}</strong>!
            </p>
            <p>
                Recebemos o seu pedido de oração e nossa equipe intercedeu por você. Confira abaixo a nossa resposta:
            </p>
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:15px; color:#14532d;">
                {{ $data['answer'] }}
            </div>
            <p style="font-size:13px; color:#666; margin-top:12px;">
                Resposta enviada por <strong>{{ $data['answered_by_name'] }}</strong>.
            </p>
            <hr style="margin:20px 0;" />
            <p style="font-size:13px; color:#666;">
                <strong>Seu pedido original:</strong><br />
                <span style="color:#0369a1;">{{ $data['message'] }}</span>
            </p>
            <p>
                Estamos em oração por você e por toda a sua família. Que a paz de Deus esteja com vocês.
            </p>
        </div>
    </div>

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <div style="width:100%; margin:20px 0; text-align:center; font-size:10px;">
                <pre>{{ $data['sitename'] }}</pre>
                <p style="font-size:10px;">Este e-mail foi enviado automaticamente. Por favor, não responda diretamente.</p>
            </div>
        @endcomponent
    @endslot

@endcomponent