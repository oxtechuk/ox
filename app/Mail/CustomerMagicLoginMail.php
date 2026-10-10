<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerMagicLoginMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $magicUrl,
        public ?string $tempPassword = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔐 رابط الدخول السريع إلى حسابك | '.config('app.name', 'Ox Tech'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.customer_magic_login',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
