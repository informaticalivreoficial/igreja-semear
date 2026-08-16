<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this
            ->subject('#Solicitação de suporte - '.$this->data['sitename'])
            ->replyTo($this->data['user_email'], $this->data['user_name'])
            ->markdown('emails.support-request', [
                'data' => $this->data,
            ]);
    }
}