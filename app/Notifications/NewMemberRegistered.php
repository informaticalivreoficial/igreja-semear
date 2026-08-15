<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMemberRegistered extends Notification
{
    use Queueable;

    public function __construct(public User $member)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Novo membro cadastrado',
            'message' => $this->member->name.' acabou de se cadastrar na plataforma.',
            'description' => 'Um novo cadastro de membro foi realizado pelo formulário público do site.',
            'url' => route('admin.users.view', $this->member->id),
            'type' => 'new_member',
            'color' => 'success',
        ];
    }
}