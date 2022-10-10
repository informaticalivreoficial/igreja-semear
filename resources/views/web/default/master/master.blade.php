<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8"/>        
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>       
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
        
        <link rel="shortcut icon" href="{{$configuracoes->getfaveicon()}}"/>
        <link rel="apple-touch-icon" href="{{$configuracoes->getfaveicon()}}"/>
        <link rel="apple-touch-icon" sizes="72x72" href="{{$configuracoes->getfaveicon()}}"/>
        <link rel="apple-touch-icon" sizes="114x114" href="{{$configuracoes->getfaveicon()}}"/>
        
        <link rel="stylesheet" type="text/css" href="{{url('frontend/assets/css/reset.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{url('frontend/assets/css/renato.css')}}"/>        

        @hasSection('css')
            @yield('css')
        @endif
</head>
<body>

<div class="container"> 
    <!-- INÍCIO DO CONTEÚDO DO SITE -->
    @yield('content')
    <!-- FIM DO CONTEÚDO DO SITE -->            
</div>
    @hasSection('js')
        @yield('js')
    @endif 

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-PWLNNT4LW4"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-PWLNNT4LW4');
    </script>
</body>
</html>