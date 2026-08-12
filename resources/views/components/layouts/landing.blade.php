<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>  
    <x-seo.meta :seo="$seo" />

    <link rel="icon" href="{{$config->getfaveicon()}}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/front.js'])

    @stack('styles')
</head>

<body class="bg-white text-slate-900 antialiased">
    @yield('content')
    @stack('scripts')
</body>
</html>