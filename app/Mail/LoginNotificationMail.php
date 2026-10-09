<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $ip;
    public string $userAgent;
    public string $loginTime;

    public function __construct(User $user, string $ip = '', string $userAgent = '')
    {
        $this->user = $user;
        $this->ip = $ip ?: 'Unknown';
        $this->userAgent = $userAgent ?: 'Web browser';
        $this->loginTime = now()->format('H:i:s d/m/Y');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Chestnut Travel] New sign-in to your account',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.login-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
