<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sessão expirada</title>
    <style>
        * { box-sizing: border-box; margin: 0; }
        body {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(180deg, #f0f7f0 0%, #e6f0e6 100%);
            color: #1f471e;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .box { text-align: center; max-width: 440px; width: 100%; }
        .icon {
            width: 84px; height: 84px; margin: 0 auto 24px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 24px; background: rgba(7, 97, 52, 0.08);
            color: #076134;
        }
        .code {
            font-size: 88px; font-weight: 800; line-height: 1;
            background: linear-gradient(135deg, #076134, #2e6028);
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -2px;
        }
        h1 { font-size: 24px; margin: 8px 0 10px; color: #1f471e; }
        p { color: #557c21; font-size: 15px; line-height: 1.6; margin-bottom: 28px; }
        a.btn {
            display: inline-flex; align-items: center; justify-content: center;
            background: #076134; color: #fff; text-decoration: none;
            padding: 12px 26px; border-radius: 12px; font-size: 14px; font-weight: 600;
            transition: background 0.2s;
        }
        a.btn:hover { background: #2e6028; }
    </style>
</head>
<body>
    <div class="box">
        <div class="icon">
            <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="code">419</div>
        <h1>Sessão expirada</h1>
        <p>Sua sessão expirou. Recarregue a página e tente novamente.</p>
        <a class="btn" href="{{ url('/') }}">Voltar para o início</a>
    </div>
</body>
</html>
