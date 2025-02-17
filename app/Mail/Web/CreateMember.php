<?php

namespace App\Mail\Web;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Markdown;

class CreateMember extends Mailable
{
    use Queueable, SerializesModels;

    private $data, $member_email;

    /**
     * Create a new message instance.
    */
    public function __construct(array $data, array $member_email)
    {
        $this->data = $data;
        $this->member_email = $member_email;
    }

    /**
     * Get the message envelope.
    */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Cadastro de novo membro', // Assunto
            from: new Address(env('MAIL_FROM_ADDRESS'), 'Comunidade Cristã Semear'), // Remetente
            to: [new Address(env('MAIL_FROM_ADDRESS'), 'Comunidade Cristã Semear')], // Destinatário
            //cc: [new Address('copia@example.com', 'Cópia')], // Cópia (opcional)
            //bcc: [new Address('oculto@example.com', 'Cópia Oculta')], // Cópia oculta (opcional)
            replyTo: [new Address($this->data['email'], 'Responder Para')],
        );
    }

    /**
     * Get the message content definition.
    */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.create-member', // View do e-mail
            with: [ 
                'member' => $this->data,
                'member_email' => $this->member_email
            ], 
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
