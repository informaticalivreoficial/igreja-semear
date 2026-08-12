<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página não encontrada</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f7f7f8;
            color: #222;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .box {
            text-align: center;
            max-width: 420px;
        }
        .code {
            font-size: 72px;
            font-weight: 700;
            color: #d1d5db;
            line-height: 1;
            margin-bottom: 10px;
        }
        h1 {
            font-size: 22px;
            margin: 0 0 12px;
        }
        p {
            color: #555;
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 28px;
        }
        a.btn {
            display: inline-block;
            background: #111;
            color: #fff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
        }
        a.btn:hover {
            background: #333;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="code">404</div>
        <h1>Página não encontrada</h1>
        <p>{{ $exception->getMessage() ?: 'O conteúdo que você procura não existe ou foi movido.' }}</p>
        <a class="btn" href="{{ url('/') }}">Voltar para o início</a>
    </div>
</body>
</html>