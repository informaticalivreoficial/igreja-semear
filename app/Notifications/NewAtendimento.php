<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewAtendimento extends Notification
{
    use Queueable;

    public function __construct(public array $data)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Nova mensagem de contato',
            'message' => $this->data['reply_name'].' enviou uma mensagem pelo formulário de Atendimento.',
            'description' => Str::limit($this->data['mensagem'], 120),
            'url' => 'mailto:'.$this->data['reply_email'],
            'type' => 'new_atendimento',
            'color' => 'info',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $contact = $this->data['reply_email'];

        if (! empty($this->data['phone'])) {
            $contact .= ' / '.$this->data['phone'];
        }

        return (new MailMessage)
            ->subject('📩 Nova mensagem de contato - '.$this->data['reply_name'])
            ->greeting('Olá '.$notifiable->name.'!')
            ->line($this->data['reply_name'].' enviou uma nova mensagem pelo formulário de Atendimento:')
            ->line('"'.$this->data['mensagem'].'"')
            ->line('Contato: '.$contact)
            ->action('Responder por e-mail', 'mailto:'.$this->data['reply_email']);
    }
}