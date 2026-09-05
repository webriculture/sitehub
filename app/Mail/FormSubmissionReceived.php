<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Site;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
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

        // The address stays platform-wide (it is what the SMTP relay is
        // verified for); the display name is the site's, so a message from
        // one client's form never arrives signed with another client's name.
        return new Envelope(
            from: new Address((string) config('mail.from.address'), $this->site->name),
            subject: $subject.' | New message',
            replyTo: isset($this->payload['email']) ? [$this->payload['email']] : [],
        );
    }

    public function content(): Content
    {
        return new Content(text: 'mail.form-submission');
    }
}
