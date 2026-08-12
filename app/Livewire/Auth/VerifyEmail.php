<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Traits\WithToastr;


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