<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;

class ForgotPassword extends Component
{
    public string $email = '';

    public bool $success = false;

    protected function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
            ],
        ];
    }

    protected array $messages = [
        'email.required' => 'Informe seu e-mail.',
        'email.email' => 'Informe um e-mail válido.',
    ];

    public function sendResetLink(): void
    {
        $this->validate();

        $status = Password::sendResetLink([
            'email' => $this->email,
        ]);

        if ($status === Password::RESET_LINK_SENT) {

            $this->success = true;

            $this->dispatch('swal:success', [
                'title' => 'Link enviado!',
                'text' => __($status),
            ]);

            return;
        }

        $this->addError(
            'email',
            __($status)
        );

        $this->dispatch('swal:error', [
            'title' => 'Erro',
            'text' => __($status),
        ]);
    }

    #[Layout('components.layouts.guest', [
        'title' => 'Recuperar Senha'
    ])]
    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}