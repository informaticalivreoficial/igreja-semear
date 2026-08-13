<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\Web\Atendimento;
use App\Mail\Web\AtendimentoRetorno;
use App\Services\ConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    protected $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function sendEmail(Request $request)
    {
        if ($request->nome == '') {
            $json = 'Por favor preencha o campo <strong>Nome</strong>';

            return response()->json(['error' => $json]);
        }
        if (! filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $json = 'O campo <strong>Email</strong> está vazio ou não tem um formato válido!';

            return response()->json(['error' => $json]);
        }
        if ($request->mensagem == '') {
            $json = 'Por favor preencha sua <strong>Mensagem</strong>';

            return response()->json(['error' => $json]);
        }
        if (! empty($request->bairro) || ! empty($request->cidade)) {
            $json = '<strong>ERRO</strong> Você está praticando SPAM!';

            return response()->json(['error' => $json]);
        }

        $data = [
            'sitename' => $this->configService->getConfig()->app_name ?? 'Semear',
            'siteemail' => $this->configService->getConfig()->email,
            'reply_name' => $request->nome,
            'reply_email' => $request->email,
            'mensagem' => $request->mensagem,
        ];

        $retorno = [
            'sitename' => $this->configService->getConfig()->app_name ?? 'Semear',
            'siteemail' => $this->configService->getConfig()->email,
            'reply_name' => $request->nome,
            'reply_email' => $request->email,
        ];

        Mail::send(new Atendimento($data));
        Mail::send(new AtendimentoRetorno($retorno));

        $json = "Obrigado {$request->nome} sua mensagem foi enviada com sucesso!";

        return response()->json(['sucess' => $json]);
    }
}
