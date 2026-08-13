@component('mail::layout')

    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
        @endcomponent
    @endslot

    {{-- Body --}}
    <div style="width:100%;">
        <div style="background:#0ea5e9; overflow:hidden; padding:15px;">
            <div style="font:16px Trebuchet MS, Arial, Helvetica, sans-serif; color:#fff; font-weight:bold;">
                Pedido de Oração
            </div>
        </div>
        <div style="background:#FFF; font:16px Trebuchet MS, Arial, Helvetica, sans-serif; color:#333; line-height:180%; padding:10px 0;">
            <p>
                <strong>Nome: </strong><span style="color:#0369a1;">{{ $data['name'] }}</span>
                <br />
                <strong>E-mail: </strong><span style="color:#0369a1;">{{ $data['email'] }}</span>
                @if($data['phone'])
                    <br />
                    <strong>Telefone: </strong><span style="color:#0369a1;">{{ $data['phone'] }}</span>
                @endif
                @if($data['privacy'] == '1')
                    <br />
                    <em>O pedido foi autorizado para divulgação/rede de oração.</em>
                @endif
                <hr />
                <strong>Pedido: </strong><br />
                <span style="color:#0369a1;">{{ $data['message'] }}</span>
            </p>
        </div>
    </div>

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <div style="width:100%; margin:20px 0; text-align:center; font-size:10px;">
                <pre>{{ $data['sitename'] }}</pre>
            </div>
        @endcomponent
    @endslot

@endcomponent
