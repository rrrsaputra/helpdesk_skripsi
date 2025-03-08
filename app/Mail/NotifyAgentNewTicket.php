<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Coderflex\LaravelTicket\Models\Ticket;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAgentNewTicket extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;

    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notify Agent New Ticket',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.email_agent',
        );
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

    public function build()
    {
        return $this->subject('New Helpdesk Ticket - Action Required')
            ->view('email.email_agent')
            ->with([
                'ticket_id' => $this->ticket->id,
                'user_name' => $this->ticket->user->name,
                'subject' => $this->ticket->title,
                'description' => $this->ticket->message,
            ]);
    }
}
