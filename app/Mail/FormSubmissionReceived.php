<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Site;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

final class FormSubmissionReceived extends Mailable
{
    public function __construct(
        public readonly Site $site,
        public readonly string $formKey,
        public readonly array $payload,
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->site->settings['form_subject']
            ?? $this->site->name.' website';

        return new Envelope(
            subject: $subject.' | New message',
            replyTo: isset($this->payload['email']) ? [$this->payload['email']] : [],
        );
    }

    public function content(): Content
    {
        return new Content(text: 'mail.form-submission');
    }
}
