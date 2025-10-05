<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceUploadedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'A new invoice has been uploaded for you',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice_uploaded',
            with: [
                'invoice' => $this->invoice, 
            ],
        );
    }

    /**
     * Attach the invoice file if available.
     */
    public function attachments(): array
    {
        $attachments = [];

        if ($this->invoice->invoice_file) {
            $path = storage_path('app/public/' . $this->invoice->invoice_file);
            if (file_exists($path)) {
                $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromPath($path)
                    ->as('invoice-' . $this->invoice->invoice_number . '.pdf')
                    ->withMime('application/pdf');
            }
        }

        return $attachments;
    }
}
