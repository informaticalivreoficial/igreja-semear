<?php

namespace App\Notifications;

use App\Models\PrayerRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewPrayerRequest extends Notification
{
    use Queueable;

    public function __construct(public PrayerRequest $prayerRequest)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Novo pedido de oração',
            'message' => $this->prayerRequest->name.' enviou um novo pedido de oração.',
            'description' => Str::limit($this->prayerRequest->message, 120),
            'url' => route('admin.prayers.index'),
            'type' => 'new_prayer_request',
            'color' => 'success',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $contact = $this->prayerRequest->email;

        if (! empty($this->prayerRequest->phone)) {
            $contact .= ' / '.$this->prayerRequest->phone;
        }

        return (new MailMessage)
            ->subject('🙏 Novo pedido de oração - '.$this->prayerRequest->name)
            ->greeting('Olá '.$notifiable->name.'!')
            ->line($this->prayerRequest->name.' enviou um novo pedido de oração:')
            ->line('"'.$this->prayerRequest->message.'"')
            ->line('Contato: '.$contact)
            ->action('Ver pedidos de oração', route('admin.prayers.index'));
    }
}