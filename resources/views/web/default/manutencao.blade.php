<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $config->app_name ?? 'Semear' }} - Em manutenção</title>
    <style>
        * { box-sizing: border-box; margin: 0; }
        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(180deg, #f0f7f0 0%, #e6f0e6 100%);
            color: #1f471e;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
        }
        .wrap { width: 100%; max-width: 680px; text-align: center; }
        .logo { max-height: 96px; max-width: 280px; margin: 0 auto 28px; }
        .logo-fallback {
            font-family: ui-sans-serif, system-ui, sans-serif;
            font-weight: 800; font-size: 28px; color: #076134;
        }
        .icon {
            width: 84px; height: 84px; margin: 0 auto 24px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 24px; background: rgba(7, 97, 52, 0.08);
            color: #076134;
        }
        h1 { font-size: 26px; margin: 0 0 12px; color: #1f471e; }
        .message { color: #557c21; font-size: 15px; line-height: 1.65; max-width: 520px; margin: 0 auto 28px; }
        .video-box {
            margin: 8px auto 28px; border-radius: 20px; overflow: hidden;
            border: 1px solid rgba(7, 97, 52, 0.12); box-shadow: 0 10px 30px rgba(7, 97, 52, 0.12);
            background: #fff;
        }
        .video-box iframe { display: block; width: 100%; aspect-ratio: 16 / 9; border: 0; }
        .video-title { padding: 12px 16px; font-size: 13px; font-weight: 600; color: #1f471e; text-align: left; }
        .contacts {
            display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin-top: 4px;
        }
        .contact {
            display: inline-flex; align-items: center; gap: 8px;
            background: #fff; border: 1px solid rgba(7, 97, 52, 0.15);
            color: #1f471e; text-decoration: none;
            padding: 10px 16px; border-radius: 999px; font-size: 13px; font-weight: 600;
            transition: border-color .2s, background .2s;
        }
        .contact:hover { border-color: #076134; background: #f0f7f0; }
        .contact svg { width: 16px; height: 16px; color: #076134; flex-shrink: 0; }
        .footer { margin-top: 32px; font-size: 12px; color: #557c21; }
        .footer a { color: #076134; text-decoration: none; font-weight: 600; }
        @media (max-width: 480px) {
            h1 { font-size: 22px; }
            .contact { font-size: 12px; padding: 8px 12px; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        @if($config && $config->logo)
            <img class="logo" src="{{ $config->getlogo() }}" alt="{{ $config->app_name }}">
        @else
            <div class="logo logo-fallback">{{ $config->app_name ?? 'Semear' }}</div>
        @endif

        <div class="icon">
            <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>

        <h1>Em manutenção</h1>
        <p class="message">{{ $config->maintenance_message ?: 'Estamos realizando melhorias no nosso site para melhor atendê-lo(a). Voltamos em breve!' }}</p>

        @if($ultimoCulto)
            <div class="video-box">
                <iframe src="{{ $ultimoCulto->embedUrl() }}" title="{{ $ultimoCulto->title }}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy"></iframe>
                <div class="video-title">&#9654; Último culto: {{ $ultimoCulto->title }}</div>
            </div>
        @endif

        @if($config && ($config->email || $config->cell_phone || $config->phone || $config->display_address))
            <div class="contacts">
                @if($config->display_address)
                    <span class="contact">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $config->display_address }}
                    </span>
                @endif
                @if($config->cell_phone || $config->phone)
                    <a class="contact" href="tel:{{ preg_replace('/[^0-9]/', '', $config->cell_phone ?: $config->phone) }}">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $config->cell_phone ?: $config->phone }}
                    </a>
                @endif
                @if($config->email)
                    <a class="contact" href="mailto:{{ $config->email }}">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ $config->email }}
                    </a>
                @endif
            </div>
        @endif

        @if($config && ($config->youtube || $config->facebook || $config->instagram))
            <div class="contacts" style="margin-top:14px">
                @if($config->youtube)
                    <a class="contact" href="{{ $config->youtube }}" target="_blank" rel="noopener">YouTube</a>
                @endif
                @if($config->facebook)
                    <a class="contact" href="{{ $config->facebook }}" target="_blank" rel="noopener">Facebook</a>
                @endif
                @if($config->instagram)
                    <a class="contact" href="{{ $config->instagram }}" target="_blank" rel="noopener">Instagram</a>
                @endif
            </div>
        @endif

        <p class="footer">&copy; {{ date('Y') }} {{ $config->app_name ?? 'Semear' }}. Todos os direitos reservados.</p>
    </div>
</body>
</html>