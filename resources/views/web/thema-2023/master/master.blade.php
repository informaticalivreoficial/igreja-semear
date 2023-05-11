<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="robots" content="noindex, nofollow">
    <meta name="author" content="{{env('DESENVOLVEDOR')}}"/>
    <meta name="copyright" content="{{$configuracoes->ano_de_inicio}} - {{$configuracoes->nomedosite}}">
    <meta name="designer" content="Renato Montanari">
    <meta name="publisher" content="Renato Montanari">
    <meta name="url" content="{{$configuracoes->dominio}}" />
    <meta name="keywords" content="{{$configuracoes->metatags}}">
    <meta name="distribution" content="web">
    <meta name="rating" content="general">
    <meta name="date" content="Dec 26">

    {!! $head ?? '' !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{$configuracoes->getfaveicon()}}" rel="icon">
    <link href="{{$configuracoes->getfaveicon()}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{url('frontend/'.$configuracoes->template.'/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('frontend/'.$configuracoes->template.'/assets/css/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{url('frontend/'.$configuracoes->template.'/assets/css/aos.css')}}" rel="stylesheet">
    <link href="{{url('frontend/'.$configuracoes->template.'/assets/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{url('frontend/'.$configuracoes->template.'/assets/css/swiper-bundle.min.css')}}" rel="stylesheet">

    <link href="{{url('frontend/'.$configuracoes->template.'/assets/css/variables.css')}}" rel="stylesheet">
    <!-- <link href="assets/css/variables-blue.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/variables-green.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/variables-orange.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/variables-purple.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/variables-red.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/variables-pink.css" rel="stylesheet"> -->

    <!-- Template Main CSS File -->
    <link href="{{url('frontend/'.$configuracoes->template.'/assets/css/main.css')}}" rel="stylesheet">

    @hasSection('css')
        @yield('css')
    @endif
</head>

<body>
    <header id="header" class="header fixed-top" data-scrollto-offset="0">
        <div class="container-fluid d-flex align-items-center justify-content-between">

            <a href="{{route('web.home')}}" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
                <img src="{{$configuracoes->getLogomarca()}}" alt="{{$configuracoes->nomedosite}}">
            </a>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto" href="index.html#about">About</a></li>
                    <li><a class="nav-link scrollto" href="index.html#team">Team</a></li>
                    <li><a href="blog.html">Blog</a></li>
                    
                    <li class="dropdown"><a href="#"><span>Drop Down</span> <i
                                class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                            <li><a href="#">Drop Down 1</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i
                                        class="bi bi-chevron-down dropdown-indicator"></i></a>
                                <ul>
                                    <li><a href="#">Deep Drop Down 1</a></li>
                                    <li><a href="#">Deep Drop Down 2</a></li>
                                    <li><a href="#">Deep Drop Down 3</a></li>
                                    <li><a href="#">Deep Drop Down 4</a></li>
                                    <li><a href="#">Deep Drop Down 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Drop Down 2</a></li>
                            <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-link scrollto" href="index.html#contact">Contact</a></li>
                    <li><a class="nav-link scrollto" href="#">Contribua</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle d-none"></i>
            </nav><!-- .navbar -->

            {{--<a class="btn-getstarted scrollto" href="index.html#about">Get Started</a>--}}

        </div>
    </header>

    @yield('content')    

    <footer id="footer" class="footer">
        <div class="footer-content">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-info">
                            <a href="{{route('web.home')}}">
                                <img src="{{url('frontend/'.$configuracoes->template.'/assets/img/logo-white.png')}}" alt="{{$configuracoes->nomedosite}}">
                            </a>
                            <p class="mt-3">
                                @if ($configuracoes->rua)
                                    {{$configuracoes->rua}}
                                    @if ($configuracoes->num)
                                        , {{$configuracoes->num}}
                                    @endif
                                @endif

                                @if ($configuracoes->bairro)
                                    <br>{{$configuracoes->bairro}}
                                    @if ($configuracoes->cidade)
                                        - {{\App\Helpers\Cidade::getCidadeNome($configuracoes->cidade, 'cidades')}}<br>
                                    @endif
                                @endif

                                @if ($configuracoes->telefone1 && !$configuracoes->telefone2)
                                    <strong>Telefone:</strong> {{$configuracoes->telefone1}}<br>
                                @elseif(!$configuracoes->telefone1 && $configuracoes->telefone2)
                                    <strong>Telefone:</strong> {{$configuracoes->telefone2}}<br>
                                @else
                                    <strong>Telefones:</strong> {{$configuracoes->telefone1}} - {{$configuracoes->telefone2}}<br>
                                @endif

                                @if ($configuracoes->telefone3)
                                    <strong>Telefone:</strong> {{$configuracoes->telefone3}}<br>
                                @endif

                                @if ($configuracoes->whatsapp)
                                    <i class="bi bi-whatsapp"></i> {{$configuracoes->whatsapp}}<br>
                                @endif
                                
                                @if ($configuracoes->email)
                                    <strong>Email:</strong> <a href="mailto:{{$configuracoes->email}}" class="__cf_email__">{{$configuracoes->email}}</a><br>
                                @endif

                                @if ($configuracoes->email1)
                                    <strong>Email:</strong> <a href="mailto:{{$configuracoes->email1}}" class="__cf_email__">{{$configuracoes->email1}}</a><br>
                                @endif                                
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Notícias</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Downloads</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Eventos</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Pedidos de Oração</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Contribua</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Fale Conosco</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Onde nos encontrar</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>Newsletter</h4>
                        <p>Cadastre seu email e receba informações sobre nossos eventos!</p>
                        <form action="" method="post" class="j_submitnewsletter" autocomplete="off">
                            @csrf
                            <!-- HONEYPOT -->
                            <input type="hidden" class="noclear" name="bairro" value="" />
                            <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                            <input type="hidden" class="noclear" name="status" value="1" />
                            <input type="hidden" class="noclear" name="nome" value="#Cadastrado pelo Site" />
                            <input type="email" name="email" class="form_hide">
                            <input class="form_hide" id="js-subscribe-btn" type="submit" value="Cadastrar">
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div class="footer-legal text-center">
            <div
                class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

                <div class="d-flex flex-column align-items-center align-items-lg-start">
                    <div class="copyright">
                        © {{$configuracoes->ano_de_inicio}} - {{date('Y')}} {{$configuracoes->nomedosite}} - Todos os direitos reservados.
                    </div>
                    <div class="credits">
                        <span class="small text-silver-dark">Feito com <i style="color:rgb(247, 242, 242);" class="bi bi-heart-fill"></i> por <a target="_blank" href="{{env('DESENVOLVEDOR_URL')}}">{{env('DESENVOLVEDOR')}}</a></span>
                    </div>
                </div>

                <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
                    @if ($configuracoes->facebook)
                        <a class="facebook" target="_blank" href="{{$configuracoes->facebook}}" title="Facebook"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if ($configuracoes->instagram)
                        <a class="instagram" target="_blank" href="{{$configuracoes->instagram}}" title="Instagram"><i class="bi bi-instagram"></i></a>
                    @endif
                    @if ($configuracoes->twitter)
                        <a class="twitter" target="_blank" href="{{$configuracoes->twitter}}" title="Twitter"><i class="bi bi-twitter"></i></a>
                    @endif
                    @if ($configuracoes->youtube)
                        <a class="youtube" target="_blank" href="{{$configuracoes->youtube}}" title="Youtube"><i class="bi bi-youtube"></i></a>
                    @endif
                    @if ($configuracoes->linkedin)
                        <a class="linkedin" target="_blank" href="{{$configuracoes->linkedin}}" title="Linkedin"><i class="bi bi-linkedin"></i></a>
                    @endif
                </div>

            </div>
        </div>

    </footer>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- JS Files -->
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/aos.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/glightbox.min.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/swiper-bundle.min.js')}}"></script>

    <!--Main JS File -->
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/main.js')}}"></script>  
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$configuracoes->tagmanager_id}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
    
        gtag('config', '{{$configuracoes->tagmanager_id}}');
    </script>
    
    @hasSection('js')
        @yield('js')
    @endif
</body>

</html>
