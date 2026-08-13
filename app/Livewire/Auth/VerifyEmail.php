<?php

namespace App\Livewire\Auth;

use App\Traits\WithToastr;
use Livewire\Attributes\Layout;
use Livewire\Component;

class VerifyEmail extends Component
{
    use WithToastr;

    public function resend()
    {
        auth()->user()->sendEmailVerificationNotification();

        $this->toastSuccess('Novo link enviado!');
    }

    #[Layout('web.client.create', ['title' => 'Verifique seu email'])]
    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
