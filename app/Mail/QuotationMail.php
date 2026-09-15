<?php

namespace App\Mail;

use App\Models\Quotation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuotationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Quotation $quotation;
    public ?string $customMessage;

    public function __construct(Quotation $quotation, ?string $customMessage = null)
    {
        $this->quotation = $quotation;
        $this->customMessage = $customMessage;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'عرض سعر تقني مخصص: ' . $this->quotation->quotation_number . ' | OX Tech',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.quotation',
        );
    }
}
