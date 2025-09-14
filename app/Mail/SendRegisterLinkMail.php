<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendRegisterLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(protected $token)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify your email to access the DTV Soft',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $env = config('app.env');
        $link = "https://app.dtvsoft.com/verify-email?token=".$this->token;
        if($env=='dev'){
            $link = "https://dev-app.dtvsoft.com/verify-email?token=".$this->token;
        }
        return new Content(
            view: 'mail.register',
            with: [
                'link' => $link,
            ]
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
