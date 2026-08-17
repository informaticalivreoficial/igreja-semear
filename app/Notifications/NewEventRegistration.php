<?php

namespace App\Notifications;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewEventRegistration extends Notification
{
    use Queueable;

    public function __construct(public EventRegistration $registration)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Nova inscrição em evento',
            'message' => $this->registration->member?->name.' se inscreveu em "'.$this->registration->event?->title.'".',
            'description' => Str::limit((string) $this->registration->notes, 120),
            'url' => route('admin.registrations.index'),
            'type' => 'new_event_registration',
            'color' => 'success',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $registration = $this->registration;
        $member = $registration->member;
        $event = $registration->event;

        return (new MailMessage)
            ->subject('📅 Nova inscrição em evento - '.($event->title ?? 'Evento'))
            ->greeting('Olá '.$notifiable->name.'!')
            ->line(($member->name ?? 'Um membro').' se inscreveu no evento "'.$event->title.'".')
            ->when($event->start_at, fn ($message) => $message->line('Data: '.$event->start_at->format('d/m/Y H:i')))
            ->when(! empty($registration->notes), fn ($message) => $message->line('Observações: '.$registration->notes))
            ->action('Ver inscrições', route('admin.registrations.index'));
    }
}