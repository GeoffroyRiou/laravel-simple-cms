<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(string $subject, public array $data, public string $template)
    {
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: $this->subject ? $this->generateContentFromTemplate($this->subject, $this->data['fields']) : 'Demande de contact',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.contact',
            with: [
                'body' => $this->generateContentFromTemplate($this->template, $this->data['fields'])
            ]
        );
    }

    private function generateContentFromTemplate(string $template, array $data): string
    {
        foreach ($data as $key => $value) {
            $value = is_array($value) ? implode(', ', $value) : $value;
            $template = str_replace('[[' . $key . ']]',  $value, $template);
        }
        return $template;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        foreach ($this->data['files'] as $path) {
            $attachments[] = Attachment::fromPath($path);
        }

        return $attachments;
    }
}
