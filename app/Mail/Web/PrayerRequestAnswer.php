<?php

namespace App\Mail\Web;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PrayerRequestAnswer extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🙏 Resposta ao seu pedido de oração - '.$this->data['sitename'],
            from: new Address($this->data['siteemail'], $this->data['sitename']),
            to: [new Address($this->data['reply_email'], $this->data['reply_name'])],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.prayer-request-answer',
            with: [
                'data' => $this->data,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}