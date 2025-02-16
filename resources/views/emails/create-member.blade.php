@component('mail::layout')

    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <!-- header here -->
        @endcomponent
    @endslot
    {{-- Body --}}
    <div style="width:100%;">
        <div style="background:#6bd1a7; overflow:hidden; padding:15px;">
            <div style="float:right; font:16px Trebuchet MS, Arial, Helvetica, sans-serif; color:#25352d; font-weight:bold;">
                Data de envio: @php echo date('d/m/Y'); @endphp
            </div>
        </div>
        <div style="background:#FFF; font:16px Trebuchet MS, Arial, Helvetica, sans-serif; color:#333; line-height:150%;">
            <p style="padding-top:10px;">
                <strong>Nome: </strong><span style="color:#09F;">{{ $member['name'] }}</span>
                <br />
                <strong>Data de Nascimento: </strong><span style="color:#09F;">{{ $member['birthday'] }}</span>
                <br />
                <strong>Sexo: </strong><span style="color:#09F;">{{ $member['gender'] }}</span>
                <br />
                <strong>Estado Civil: </strong><span style="color:#09F;">{{ $member['civil_status'] }}</span>
                <br />
                <hr />
                <strong>E-mail: </strong><span style="color:#09F;">{{ $member['email'] }}</span>
                <br />
                <strong>Celular/WhatsApp: </strong><span style="color:#09F;">{{ $member['whatsapp'] }}</span>
                <br />
                <hr />
                <strong>Rua: </strong><span style="color:#09F;margin-right: 20px;">{{ $member['street'] }}</span>
                <strong>Número: </strong><span style="color:#09F;margin-right: 20px;">{{ $member['number'] }}</span>
                <strong>Bairro: </strong><span style="color:#09F;">{{ $member['neighborhood'] }}</span>
                <br />
                <strong>Cidade: </strong><span style="color:#09F;margin-right: 20px;">{{ $member['city'] }}</span>
                <strong>UF: </strong><span style="color:#09F;margin-right: 20px;">{{ $member['state'] }}</span>
                <strong>Cep: </strong><span style="color:#09F;margin-right: 20px;">{{ $member['postcode'] }}</span>
                <strong>Complemento: </strong><span style="color:#09F;">{{ $member['complement'] }}</span>
                <br />
                <hr />
                <strong>É batizado(a)? </strong><br /><span
                    style="color:#09F;margin-right: 20px;">{{ ($member['baptism'] == 'true' ? 'Sim' : 'Não') }}</span>
                @if ($member['baptism'] == 'true')
                <br /><strong>Data do batismo: </strong><br /><span style="color:#09F;">{{ $member['baptism_date'] }}</span>
                @else
                <br /><strong>Deseja se Batizar? </strong><br /><span
                        style="color:#09F;">{{ ($member_email['baptism_option'] == 'true' ? 'Sim' : 'Não') }}</span>
                @endif
                <br />
                <strong>Frequenta a Semear a quanto Tempo? </strong><br /><span
                    style="color:#09F;">{{ $member_email['period_frequenci'] }}</span>
                <br /><strong>Participa dos grupos de WhatsApp da igreja? </strong><br /><span
                    style="color:#09F;">{{ ($member_email['whatsapp_group'] == 'true' ? 'Sim' : 'Não') }}</span>
                @if ($member_email['whatsapp_group'] == 'false')
                    <br /><strong>Gostaria de participar? </strong><br /><span
                        style="color:#09F;">{{ ($member_email['whatsapp_group_accept'] == 'true' ? 'Sim' : 'Não') }}</span>
                @endif
                <br /><strong>Participa de algum ministério da igreja? </strong><br /><span
                    style="color:#09F;">{{ ($member_email['ministerio_group'] == 'true' ? 'Sim' : 'Não') }}</span>
                @if ($member_email['ministerio_group'] == 'true')
                <br /><strong>Qual? </strong><br /><span
                    style="color:#09F;">{{ $member_email['ministerio_name'] }}</span>
                @endif
                @if ($member_email['ministerio_group'] == 'false')
                <br /><strong>Gostaria de participar de algum ministério? </strong><br /><span
                    style="color:#09F;">{{ ($member_email['ministerio_accept'] == 'true' ? 'Sim' : 'Não') }}</span>
                    @if ($member_email['ministerio_accept'] == 'true')
                        <br /><strong>Qual? </strong><br /><span
                        style="color:#09F;">{{ $member_email['ministerio_accept_name'] }}</span>
                    @endif
                @endif
                <br />                
                <strong>Gostaria de agendar um horário na igreja para nos conhecer melhor? </strong><br /><span
                    style="color:#09F;">{{ ($member_email['hour_accept'] == 'true' ? 'Sim' : 'Não') }}</span>
                <br /><strong>Podemos entrar em contato para agendar? </strong><br /><span
                    style="color:#09F;">{{ ($member_email['hour_accept_agend'] == 'true' ? 'Sim' : 'Não') }}</span>
            </p>
        </div>
    </div>
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <div style="width:100%; margin:20px 0; text-align:center; font-size:10px;">
                <pre>Sistema de consultas desenvolvido por {{ env('DESENVOLVEDOR') }} <br> <a href="mailto:{{ env('DESENVOLVEDOR_EMAIL') }}">{{ env('DESENVOLVEDOR_EMAIL') }}</a></pre>
            </div>
        @endcomponent
    @endslot

@endcomponent
