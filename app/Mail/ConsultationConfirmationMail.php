<?php

namespace App\Mail;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultationConfirmationMail extends Mailable implements ShouldQueue
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
            subject: 'تأكيد استلام طلب استشارتك التقنية | OX Tech',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.consultation-confirmation',
        );
    }
}
