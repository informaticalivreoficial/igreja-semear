<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;

class ResetPassword extends Component
{
    public string $token = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $success = false;

    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->query('email', '');
    }

    protected function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'confirmed',
                'min:6',
            ],
        ];
    }

    protected array $messages = [
        'email.required' => 'Informe seu e-mail.',
        'email.email' => 'Informe um e-mail válido.',

        'password.required' => 'Informe a nova senha.',
        'password.confirmed' => 'As senhas não coincidem.',
        'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
    ];

    public function resetPassword(): void
    {
        $this->validate();

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],

            function (User $user, string $password) {

                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {

            $this->success = true;

            $this->reset([
                'password',
                'password_confirmation',
            ]);

            $this->dispatch('swal:success', [
                'title' => 'Senha alterada!',
                'text' => 'Sua senha foi redefinida com sucesso.',
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
        'title' => 'Redefinir Senha'
    ])]
    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}