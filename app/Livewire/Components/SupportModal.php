<?php

namespace App\Livewire\Components;

use App\Mail\Admin\SupportRequestMail;
use App\Models\Config;
use App\Traits\WithToastr;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class SupportModal extends Component
{
    use WithToastr;

    public bool $showSupport = false;

    public string $message = '';

    #[On('open-support-modal')]
    public function open()
    {
        $this->showSupport = true;
    }

    public function sendSupport()
    {
        $this->validate([
            'message' => 'required|min:10',
        ]);

        $user = auth()->user();
        $config = Config::find(1);

        $data = [
            'mensagem' => $this->message,
            'user_name' => $user?->name ?: 'Administrador',
            'user_email' => $user?->email ?: config('app.desenvolvedor_email'),
            'sitename' => $config?->app_name ?: config('app.name'),
        ];

        try {
            Mail::to(config('app.desenvolvedor_email'))
                ->send(new SupportRequestMail($data));

            $this->reset('message', 'showSupport');
            $this->toastSuccess('Suporte enviado com sucesso');
        } catch (\Throwable $e) {
            $this->toastError('Não foi possível enviar o suporte. Tente novamente mais tarde.');
        }
    }

    public function render()
    {
        return view('livewire.components.support-modal');
    }
}