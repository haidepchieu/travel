<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Chestnut Travel] Welcome to Chestnut Travel!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.register-welcome',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
