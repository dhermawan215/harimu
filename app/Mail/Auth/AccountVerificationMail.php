<?php

namespace App\Mail\Auth;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class AccountVerificationMail extends Mailable
{
    public function __construct(
        private string $userName,
        private string $actionUrl,
        private int $expireMinutes
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifikasi email akun ' . config('app.name', 'Harimu'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.auth.account-verification',
            with: [
                'preheader' => 'Klik tautan untuk memverifikasi email dan mengaktifkan akun Anda.',
                'name' => $this->userName,
                'action_url' => $this->actionUrl,
                'expire_minutes' => $this->expireMinutes,
            ],
        );
    }
}
