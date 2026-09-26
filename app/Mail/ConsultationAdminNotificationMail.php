<?php

namespace App\Mail;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultationAdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Consultation $consultation;

    public function __construct(Consultation $consultation)
    {
        $this->consultation = $consultation;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'طلب استشارة جديد من: '.$this->consultation->name.' [مصدر: '.($this->consultation->platform_detected ?? 'Direct').']',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.consultation-admin',
        );
    }
}
