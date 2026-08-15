<?php

namespace App\Livewire\Web;

use App\Mail\Web\PrayerRequest as PrayerRequestMail;
use App\Models\PrayerRequest as PrayerRequestModel;
use App\Models\User;
use App\Notifications\NewPrayerRequest;
use App\Services\ConfigService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class PrayerRequest extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $message = '';

    public bool $privacy = false;

    protected $rules = [
        'name' => 'required|min:3|max:120',
        'email' => 'required|email|max:120',
        'phone' => 'nullable|string|max:20|regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/',
        'message' => 'required|min:10|max:1000',
        'privacy' => 'accepted',
    ];

    protected $messages = [
        'name.required' => 'Informe o seu nome.',
        'name.min' => 'Informe um nome válido.',
        'email.required' => 'Informe o seu e-mail.',
        'email.email' => 'Informe um e-mail válido.',
        'phone.regex' => 'Informe um telefone válido: (00) 00000-0000.',
        'message.required' => 'Escreva o seu pedido de oração.',
        'message.min' => 'Escreva um pedido com mais detalhes (mínimo de 10 caracteres).',
        'privacy.accepted' => 'É necessário concordar com a política de privacidade.',
    ];

    public function send(ConfigService $configService)
    {
        $this->validate();

        $config = $configService->getConfig();

        Mail::send(new PrayerRequestMail([
            'sitename' => $config->app_name ?? 'Semear',
            'siteemail' => $config->email,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
            'privacy' => $this->privacy ? '1' : '0',
        ]));

        $prayerRequest = PrayerRequestModel::create([
            'member_id' => Auth::user()?->member?->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
            'status' => PrayerRequestModel::STATUS_PENDENTE,
        ]);

        $admins = User::role(['super admin', 'admin', 'pastor', 'lider'])->get();

        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewPrayerRequest($prayerRequest));
        }

        $this->reset();

        $this->dispatch('pedido-enviado', name: '');
    }

    public function render()
    {
        return view('livewire.web.prayer-request');
    }
}
