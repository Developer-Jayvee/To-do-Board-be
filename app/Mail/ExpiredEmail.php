<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExpiredEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $nearExpirationTickets;
    public $nearDateCount;
    /**
     * Create a new message instance.
     */
    public function __construct($nearExpirationTickets , $nearDateCount)
    {
        $this->nearExpirationTickets = $nearExpirationTickets;
        $this->nearDateCount = $nearDateCount;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'FINAL NOTICE: Your ticket expires TODAY',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.expiredTicket',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
