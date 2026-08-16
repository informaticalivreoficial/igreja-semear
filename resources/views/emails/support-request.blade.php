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
                Solicitação de suporte
            </div>
        </div>
        <div style="background:#FFF; font:16px Trebuchet MS, Arial, Helvetica, sans-serif; color:#333; line-height:180%; padding:10px 0;">
            <p>
                Você recebeu uma nova solicitação de suporte:
            </p>
            <div style="background:#f5f1ee; border:1px solid #d7c8b8; border-radius:8px; padding:15px; color:#433125;">
                {{ $data['mensagem'] }}
            </div>
            <hr style="margin:20px 0;" />
            <p style="font-size:13px; color:#666;">
                <strong>Solicitante:</strong> {{ $data['user_name'] }} &lt;{{ $data['user_email'] }}&gt;<br />
                <strong>Site:</strong> {{ $data['sitename'] }}
            </p>
        </div>
    </div>

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <div style="width:100%; margin:20px 0; text-align:center; font-size:10px;">
                <p style="font-size:10px;">Este e-mail foi enviado automaticamente pelo painel administrativo.</p>
            </div>
        @endcomponent
    @endslot

@endcomponent