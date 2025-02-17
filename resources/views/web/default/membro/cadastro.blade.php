<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="{{env('DESENVOLVEDOR')}}"/>
    <meta name="copyright" content="{{$configuracoes->init_date}} - {{$configuracoes->app_name}}">
    <meta name="designer" content="{{env('ADMIN_NOME')}}">
    <meta name="publisher" content="{{env('ADMIN_NOME')}}">
    <meta name="url" content="{{$configuracoes->domain}}" />
    <meta name="keywords" content="{{$configuracoes->metatags}}">
    <meta name="distribution" content="web">
    <meta name="rating" content="general">
    <meta name="date" content="Dec 26">

    {!! $head ?? '' !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{$configuracoes->getfaveicon()}}"/>
    <link rel="apple-touch-icon" href="{{$configuracoes->getfaveicon()}}"/>
    <link rel="apple-touch-icon" sizes="72x72" href="{{$configuracoes->getfaveicon()}}"/>
    <link rel="apple-touch-icon" sizes="114x114" href="{{$configuracoes->getfaveicon()}}"/>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

</head>

<body>

    <div class="container">
        
        <img class="mx-auto d-block mt-3 mb-3" src="{{$configuracoes->getLogo()}}" alt="{{$configuracoes->app_name}}">
        
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <header class="card-header form_hide">
                        <h5 class="card-title mt-2 text-center">Cadastro de Membros</h5>
                    </header>
                    <article class="card-body form_hide">
                        <form method="post" action="" class="j_formsubmit" autocomplete="off">
                            @csrf
                            <div class="form-row">
                                <div class="col-12 col-lg-5 col-md-8 col-sm-8 form-group">
                                    <!-- HONEYPOT -->
                                    <input type="hidden" class="noclear" name="bairro" value="" />
                                    <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                                    <label class="font-weight-bold">Nome </label>
                                    <input type="text" name="name" class="form-control" placeholder="Nome Completo" value="{{ old('name') }}">
                                </div> 
                                <div class="col-12 col-lg-3 col-md-4 col-sm-4 form-group">
                                    <label class="font-weight-bold">Data de Nasc.</label>
                                    <input type="text" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}">
                                </div> 
                                <div class="col-12 col-lg-4 col-md-6 col-sm-6 form-group">
                                    <label class="d-block font-weight-bold">Sexo</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="masculino" {{(old('gender') == 'masculino' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Masculino </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="feminino" {{(old('gender') == 'feminino' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Feminino</span>
                                    </label>
                                </div> 
                                <div class="col-12 col-lg-4 col-md-6 col-sm-6 form-group">
                                    <label class="font-weight-bold">Estado Civil</label>
                                    <select name="civil_status" id="inputState" class="form-control">
                                        <option value="solteiro" {{ (old('estado_civil') == 'solteiro' ? 'selected' : '') }}>Solteiro</option>
                                        <option value="casado" {{ (old('estado_civil') == 'casado' ? 'selected' : '') }}>Casado</option>
                                        <option value="separado" {{ (old('estado_civil') == 'separado' ? 'selected' : '') }}>Separado</option>                                        
                                        <option value="divorciado" {{ (old('estado_civil') == 'divorciado' ? 'selected' : '') }}>Divorciado</option>
                                        <option value="viuvo" {{ (old('estado_civil') == 'viuvo' ? 'selected' : '') }}>Viúvo(a)</option>
                                    </select>
                                </div> 
                                <div class="col-12 col-lg-4 col-md-6 col-sm-6 form-group">
                                    <label class="font-weight-bold">Email</label>
                                    <input type="email" class="form-control" placeholder="Digite aqui seu melhor email" name="email" value="{{ old('email') }}">
                                </div> 
                                <div class="col-12 col-lg-4 col-md-6 col-sm-6 form-group">
                                    <label class="font-weight-bold">Celular/WhatsApp</label>
                                    <input type="text" class="form-control celularmask" placeholder="Celular/WhatsApp" name="whatsapp" value="{{ old('whatsapp') }}">
                                </div> 
                            </div> 
                            
                            <hr>
                            
                            <div class="form-row">
                                <div class="col-lg-2 col-md-3 col-sm-4 col-12 form-group">
                                    <label class="font-weight-bold">Cep</label>
                                    <input type="text" class="form-control" name="postcode" id="cep">
                                </div> 
                                <div class="col-lg-4 col-md-5 col-sm-8 col-12 form-group">
                                    <label class="font-weight-bold">Rua</label>
                                    <input type="text" class="form-control" name="street" id="rua">
                                </div>                             
                                <div class="col-lg-3 col-md-4 col-sm-8 col-12 form-group">
                                    <label class="font-weight-bold">Bairro</label>
                                    <input type="text" class="form-control" name="neighborhood" id="bairro">
                                </div> 
                                <div class="col-lg-3 col-md-2 col-sm-4 col-12 form-group">
                                    <label class="font-weight-bold">UF</label>
                                    <input type="text" class="form-control" name="state" id="uf">
                                </div>                            
                                <div class="col-lg-5 col-md-5 col-sm-6 col-12 form-group">
                                    <label class="font-weight-bold">Cidade</label>
                                    <input type="text" class="form-control" name="city" id="cidade">
                                </div>                             
                                                             
                                <div class="col-lg-3 col-md-2 col-sm-2 col-12 form-group">
                                    <label class="font-weight-bold">Número</label>
                                    <input type="text" class="form-control" name="number">
                                </div>                             
                                <div class="col-lg-4 col-md-3 col-sm-4 col-12 form-group">
                                    <label class="font-weight-bold">Complemento</label>
                                    <input type="text" class="form-control" name="complement">
                                </div>                             
                            </div>
                            
                            <hr>

                            <div class="form-row">
                                <div class="col-12 col-lg-4 col-md-6 col-sm-6 form-group">
                                    <label class="d-block font-weight-bold">É batizado(a)?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="baptism" value="true" {{(old('baptism') == 'true' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="baptism" value="false" {{(old('baptism') == 'false' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                                <div class="col-12 col-lg-4 col-md-6 col-sm-6 form-group baptism-on">
                                    <label class="font-weight-bold">Data do batismo</label>
                                    <input type="text" class="form-control" name="baptism_date" id="baptism">
                                </div>
                                <div class="col-12 col-lg-4 col-md-6 col-sm-6 form-group" id="baptism-option">
                                    <label class="d-block font-weight-bold">Deseja se Batizar?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="baptism_option" value="true" {{(old('baptism_option') == 'true' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="baptism_option" value="false" {{(old('baptism_option') == 'false' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>

                                
                                
                            </div>

                            <div class="form-row">
                                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-group">
                                    <label class="font-weight-bold">Frequenta a Semear a quanto Tempo?</label>
                                    <input type="text" class="form-control" name="period_frequenci">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12 col-lg-6 col-md-8 col-sm-12 form-group">
                                    <label class="d-block font-weight-bold">Participa dos grupos de WhatsApp da igreja?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="whatsapp_group" value="true" {{(old('whatsapp_group') == 'true' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="whatsapp_group" value="false" {{(old('whatsapp_group') == 'false' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                                <div class="col-12 col-lg-6 col-md-4 col-sm-12 form-group" id="whatsapp-option">
                                    <label class="d-block font-weight-bold">Gostaria de participar?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="whatsapp_group_accept" value="true" {{(old('whatsapp_group_accept') == 'true' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="whatsapp_group_accept" value="false" {{(old('whatsapp_group_accept') == 'false' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12 col-lg-6 col-md-8 col-sm-12 form-group">
                                    <label class="d-block font-weight-bold">Participa de algum ministério da igreja?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ministerio_group" value="true" {{(old('ministerio_group') == 'true' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ministerio_group" value="false" {{(old('ministerio_group') == 'false' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                                <div class="col-12 col-lg-6 col-md-4 col-sm-12 form-group" id="ministerio-option">
                                    <label class="font-weight-bold">Qual?</label>
                                    <input type="text" class="form-control" name="ministerio_name">
                                </div>
                            </div>

                            <div class="form-row" id="ministerio-accept">
                                <div class="col-12 col-lg-6 col-md-8 col-sm-12 form-group">
                                    <label class="d-block font-weight-bold">Gostaria de participar de algum ministério?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ministerio_accept" value="true" {{(old('ministerio_accept') == 'true' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ministerio_accept" value="false" {{(old('ministerio_accept') == 'false' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                                <div class="col-12 col-lg-6 col-md-4 col-sm-12 form-group" id="ministerio-accept-option">
                                    <label class="font-weight-bold">Qual?</label>
                                    <input type="text" class="form-control" name="ministerio_accept_name">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-group">
                                    <label class="d-block font-weight-bold">Gostaria de agendar um horário na igreja para nos conhecer melhor?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="hour_accept" value="true" {{(old('hour_accept') == 'true' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="hour_accept" value="false" {{(old('hour_accept') == 'false' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-group">
                                    <label class="d-block font-weight-bold">Podemos entrar em contato para agendar?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="hour_accept_agend" value="true" {{(old('hour_accept_agend') == 'true' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="hour_accept_agend" value="false" {{(old('hour_accept_agend') == 'false' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                            </div>

                           
                            <div class="form-group">
                                <button id="js-contact-btn" type="submit" class="btn btn-success btn-block noclear"> Cadastrar Agora </button>
                            </div>
                            <small class="text-muted">Ao clicar no botão de cadastrar, você confirma e aceita
                                os Termos de uso e <a target="_blank" href="{{route('web.politica')}}">Política de Privacidade</a>.</small>
                        </form>
                    </article> 
                    
                </div> 
            </div> 

        </div> 

    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>       
    <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script> 
    <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/locales/bootstrap-datepicker.pt-BR.min.js" charset="UTF-8"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script> 
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var $celularmask = $(".celularmask");
        $celularmask.mask('(99) 99999-9999', {reverse: false});

        $('#birthday').datepicker({
            format: "dd/mm/yyyy",
            language: "pt-BR",
            autoclose: true
        });

        $('#baptism').datepicker({
            format: "dd/mm/yyyy",
            language: "pt-BR",
            autoclose: true
        });

        $(".baptism-on").attr("style", "display:none");
        $("#baptism-option").attr("style", "display:none");

        $('input[name="baptism"]').on('change', function() {
            if ($(this).val() === 'true') {
                $(".baptism-on").attr("style", "display:block");
                $("#baptism-option").attr("style", "display:none");
            } else {
                $(".baptism-on").attr("style", "display:none");
                $("#baptism-option").attr("style", "display:block");
            }
        });

        $("#whatsapp-option").attr("style", "display:none");

        $('input[name="whatsapp_group"]').on('change', function() {
            if ($(this).val() === 'true') {
                $("#whatsapp-option").attr("style", "display:none");
            } else {
                $("#whatsapp-option").attr("style", "display:block");
            }
        });

        $("#ministerio-option").attr("style", "display:none");

        $('input[name="ministerio_group"]').on('change', function() {
            if ($(this).val() === 'true') {
                $("#ministerio-option").attr("style", "display:block");
            } else {
                $("#ministerio-option").attr("style", "display:none");
            }
        });

        $("#ministerio-accept-option").attr("style", "display:none");

        $('input[name="ministerio_accept"]').on('change', function() {
            if ($(this).val() === 'true') {
                $("#ministerio-accept-option").attr("style", "display:block");
            } else {
                $("#ministerio-accept-option").attr("style", "display:none");
            }
        });

        $("#ministerio-accept").attr("style", "display:none");

        $('input[name="ministerio_group"]').on('change', function() {
            if ($(this).val() === 'false') {
                $("#ministerio-accept").attr("style", "display:block");
            } else {
                $("#ministerio-accept").attr("style", "display:none");
            }
        });

        // Seletor, Evento/efeitos, CallBack, Ação
        $('.j_formsubmit').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: "{{ route('web.create.member.send') }}",
                data: dataString,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function(){
                    form.find("#js-contact-btn").attr("disabled", true);
                    form.find('#js-contact-btn').text("Carregando...");
                },
                success: function(resposta){
                    if(resposta.error){
                        toastr.error(resposta.error, 'Erro')          
                    }else{
                        setTimeout(function() {
                            form.find('input[class!="noclear"]').val('');
                            $('.form_hide').fadeOut(500);
                        }, 2000); 
                        Swal.fire({
                            title: 'Obrigado ' + resposta.name,
                            text: resposta.cadastro,
                            icon: 'success',
                            confirmButtonText: 'ok'
                        }).then((result) => {
                            if(result.isConfirmed){
                                window.location.href = "{{ route('web.home') }}";
                            }
                        });
                    }
                },
                complete: function(resposta){
                    form.find("#js-contact-btn").attr("disabled", false);
                    form.find('#js-contact-btn').text("Cadastrar Agora");                                
                }
            });

            return false;
        });

    });

    

    $(document).ready(function() {

        function limpa_formulário_cep() {
            $("#rua").val("");
            $("#bairro").val("");
            $("#cidade").val("");
            $("#uf").val("");
        }

        $("#cep").blur(function() {

            var cep = $(this).val().replace(/\D/g, '');

            if (cep != "") {
                
                var validacep = /^[0-9]{8}$/;

                if(validacep.test(cep)) {
                    
                    $("#rua").val("Carregando...");
                    $("#bairro").val("Carregando...");
                    $("#cidade").val("Carregando...");
                    $("#uf").val("Carregando...");
                    
                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            $("#rua").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#uf").val(dados.uf);
                        } else {
                            limpa_formulário_cep();
                            toastr.error('CEP não encontrado.', 'Erro')
                        }
                    });
                } else {
                    limpa_formulário_cep();
                    toastr.error('Formato de CEP inválido.', 'Erro')
                }
            } else {
                limpa_formulário_cep();
            }
        });
    });
</script> 

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PWLNNT4LW4"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-PWLNNT4LW4');
</script>
</body>

</html>
