<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\Web\Atendimento;
use App\Mail\Web\AtendimentoRetorno;
use App\Models\User;
use App\Notifications\NewAtendimento;
use App\Services\ConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendEmailController extends Controller
{
    protected $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function sendEmail(Request $request)
    {
        if (! empty($request->bairro) || ! empty($request->cidade)) {
            return response()->json(['error' => '<strong>ERRO</strong> Você está praticando SPAM!']);
        }

        $name = trim((string) $request->input('nome', ''));
        $email = trim((string) $request->input('email', ''));
        $phone = trim((string) $request->input('phone', ''));
        $message = trim((string) $request->input('mensagem', ''));
        $privacy = $request->input('privacy');

        if (mb_strlen($name) < 3) {
            return response()->json(['error' => 'Informe o seu <strong>Nome</strong> completo.']);
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['error' => 'O campo <strong>E-mail</strong> está vazio ou não tem um formato válido!']);
        }

        if (! empty($phone) && ! preg_match('/^\(\d{2}\)\s?\d{4,5}-\d{4}$/', $phone)) {
            return response()->json(['error' => 'Informe um <strong>Telefone</strong> válido: (00) 00000-0000.']);
        }

        if (mb_strlen($message) < 10) {
            return response()->json(['error' => 'Escreva uma <strong>Mensagem</strong> com pelo menos 10 caracteres.']);
        }

        if (! in_array($privacy, ['1', 'true'], true)) {
            return response()->json(['error' => 'É necessário concordar com a <strong>Política de Privacidade</strong>.']);
        }

        $config = $this->configService->getConfig();

        $data = [
            'sitename' => $config?->app_name ?? 'Semear',
            'siteemail' => $config?->email,
            'reply_name' => $name,
            'reply_email' => $email,
            'phone' => $phone,
            'mensagem' => $message,
            'privacy' => $privacy,
        ];

        $retorno = [
            'sitename' => $config?->app_name ?? 'Semear',
            'siteemail' => $config?->email,
            'reply_name' => $name,
            'reply_email' => $email,
        ];

        Mail::send(new Atendimento($data));
        Mail::send(new AtendimentoRetorno($retorno));

        $admins = User::role(['super admin', 'admin', 'pastor', 'lider'])->get();

        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewAtendimento($data));
        }

        return response()->json(['sucess' => "Obrigado {$name}, sua mensagem foi enviada com sucesso!"]);
    }
}