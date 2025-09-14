<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class InvoiceCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($invoices, $pdfs,$current_user_name)
    {
        $this->invoices = $invoices;
        $this->pdfs = $pdfs;
        $this->current_user_name = $current_user_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoices created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.invoice',
            with: [
                'invoices' => $this->invoices,
                'current_user_name' => $this->current_user_name,
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
       
        $attachments = [];

        foreach ($this->pdfs as $pdf) {
            $base64Data = str_replace('data:application/pdf;base64, ', '', $pdf['content']); // Prefixni olib tashlash

            $attachments[] = Attachment::fromData(
                fn () => base64_decode($base64Data),
                $pdf['filename']
            )->withMime('application/pdf');
        }

        return $attachments;
    }
}
