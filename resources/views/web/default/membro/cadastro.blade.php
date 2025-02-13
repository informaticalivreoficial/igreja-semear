<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {!! $head ?? '' !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
</head>

<body>

    <div class="container">
        <br>
        <img src="" alt="">
        <hr>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <header class="card-header">
                        <h5 class="card-title mt-2 text-center">Cadastro de Membros</h5>
                    </header>
                    <article class="card-body">
                        <form>
                            <div class="form-row">
                                <div class="col-12 col-lg-5 col-md-8 col-sm-8 form-group">
                                    <label class="font-weight-bold">Nome </label>
                                    <input type="text" name="name" class="form-control" placeholder="Nome Completo">
                                </div> 
                                <div class="col-12 col-lg-3 col-md-4 col-sm-4 form-group">
                                    <label class="font-weight-bold">Data de Nasc.</label>
                                    <input type="text" class="form-control" name="birthday">
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
                                        <option value="casado" {{ (old('estado_civil') == 'casado' ? 'selected' : '') }}>Casado</option>
                                        <option value="separado" {{ (old('estado_civil') == 'separado' ? 'selected' : '') }}>Separado</option>
                                        <option value="solteiro" {{ (old('estado_civil') == 'solteiro' ? 'selected' : '') }}>Solteiro</option>
                                        <option value="divorciado" {{ (old('estado_civil') == 'divorciado' ? 'selected' : '') }}>Divorciado</option>
                                        <option value="viuvo" {{ (old('estado_civil') == 'viuvo' ? 'selected' : '') }}>Viúvo(a)</option>
                                    </select>
                                </div> 
                                <div class="col-12 col-lg-4 col-md-6 col-sm-6 form-group">
                                    <label class="font-weight-bold">Email</label>
                                    <input type="email" class="form-control" placeholder="Digite aqui seu melhor email">
                                </div> 
                                <div class="col-12 col-lg-4 col-md-6 col-sm-6 form-group">
                                    <label class="font-weight-bold">Celular/WhatsApp</label>
                                    <input type="text" class="form-control" placeholder="Celular/WhatsApp">
                                </div> 
                            </div> 
                            
                            <hr>
                            
                            <div class="form-row">
                                <div class="col-lg-2 col-md-3 col-sm-4 col-12 form-group">
                                    <label class="font-weight-bold">Cep</label>
                                    <input type="text" class="form-control" name="postcode">
                                </div> 
                                <div class="col-lg-4 col-md-5 col-sm-8 col-12 form-group">
                                    <label class="font-weight-bold">Rua</label>
                                    <input type="text" class="form-control" name="street">
                                </div>                             
                                <div class="col-lg-3 col-md-4 col-sm-8 col-12 form-group">
                                    <label class="font-weight-bold">Bairro</label>
                                    <input type="text" class="form-control" name="neighborhood">
                                </div> 
                                <div class="col-lg-3 col-md-2 col-sm-4 col-12 form-group">
                                    <label class="font-weight-bold">UF</label>
                                    <input type="text" class="form-control" name="state">
                                </div>                            
                                <div class="col-lg-5 col-md-5 col-sm-6 col-12 form-group">
                                    <label class="font-weight-bold">Cidade</label>
                                    <input type="text" class="form-control" name="city">
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
                                    <label class="d-block font-weight-bold">É batizado(a)</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="baptism" value="1" {{(old('baptism') == '1' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="baptism" value="0" {{(old('baptism') == '0' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                                <div class="col-12 col-lg-4 col-md-6 col-sm-6 form-group">
                                    <label class="font-weight-bold">Data do batismo</label>
                                    <input type="text" class="form-control" name="baptism_date">
                                </div>
                                <div class="col-12 col-lg-4 col-md-6 col-sm-6 form-group">
                                    <label class="d-block font-weight-bold">Deseja se Batizar?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="baptism-option" value="1" {{(old('baptism-option') == '1' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="baptism-option" value="0" {{(old('baptism-option') == '0' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>

                                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-group">
                                    <label class="font-weight-bold">Frequenta a Semear a quanto Tempo?</label>
                                    <input type="text" class="form-control" name="period_frequenci">
                                </div>
                                
                            </div>

                            <div class="form-row">
                                <div class="col-12 col-lg-6 col-md-8 col-sm-12 form-group">
                                    <label class="d-block font-weight-bold">Participa dos grupos de WhatsApp da igreja?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="whatsapp_group" value="1" {{(old('whatsapp_group') == '1' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="whatsapp_group" value="0" {{(old('whatsapp_group') == '0' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                                <div class="col-12 col-lg-6 col-md-4 col-sm-12 form-group">
                                    <label class="d-block font-weight-bold">Gostaria de participar?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="whatsapp_group" value="1" {{(old('whatsapp_group') == '1' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="whatsapp_group" value="0" {{(old('whatsapp_group') == '0' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12 col-lg-6 col-md-8 col-sm-12 form-group">
                                    <label class="d-block font-weight-bold">Participa de algum ministério da igreja?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ministerio_group" value="1" {{(old('ministerio_group') == '1' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ministerio_group" value="0" {{(old('ministerio_group') == '0' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                                <div class="col-12 col-lg-6 col-md-4 col-sm-12 form-group">
                                    <label class="font-weight-bold">Qual?</label>
                                    <input type="text" class="form-control" name="ministerio_name">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12 col-lg-6 col-md-8 col-sm-12 form-group">
                                    <label class="d-block font-weight-bold">Gostaria de participar de algum ministério?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ministerio_accept" value="1" {{(old('ministerio_accept') == '1' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ministerio_accept" value="0" {{(old('ministerio_accept') == '0' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                                <div class="col-12 col-lg-6 col-md-4 col-sm-12 form-group">
                                    <label class="font-weight-bold">Qual?</label>
                                    <input type="text" class="form-control" name="ministerio_accept_name">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-group">
                                    <label class="d-block font-weight-bold">Gostaria de agendar um horário na igreja para nos conhecer melhor?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="hour_accept" value="1" {{(old('hour_accept') == '1' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="hour_accept" value="0" {{(old('hour_accept') == '0' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-group">
                                    <label class="d-block font-weight-bold">Podemos entrar em contato para agendar?</label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="hour_accept_agend" value="1" {{(old('hour_accept_agend') == '1' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Sim </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="hour_accept_agend" value="0" {{(old('hour_accept_agend') == '0' ? 'checked' : '') }}>
                                        <span class="form-check-label"> Não</span>
                                    </label>
                                </div>
                            </div>

                           
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block"> Cadastrar Agora </button>
                            </div>
                            <small class="text-muted">Ao clicar no botão de cadastrar, você confirma e aceita
                                os Termos de uso e Política de Privacidade.</small>
                        </form>
                    </article> 
                    
                </div> 
            </div> 

        </div> 

    </div>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
