<?php

namespace App\Mail;

use App\Models\Mail;
use Illuminate\Support\Facades\Blade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

abstract class BaseMailTemplate extends Mailable
{
    use Queueable, SerializesModels;

    public Mail $mailTemplate;
    public array $variables;

    /**
     * Create a new message instance.
     */
    public function __construct(Mail $mail_template, array $variables)
    {
        $this->mailTemplate = $mail_template;
        $this->variables = $variables;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailTemplate->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $body = Blade::render($this->mailTemplate->body, $this->variables);

        return new Content(htmlString: $body);
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
