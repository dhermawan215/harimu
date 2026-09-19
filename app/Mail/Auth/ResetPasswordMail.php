<?php

namespace App\Mail\Auth;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ResetPasswordMail extends Mailable
{
    public function __construct(
        private string $userName,
        private string $actionUrl,
        private int $expireMinutes,
        private string $requestIp,
        private string $requestTime
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Atur ulang kata sandi akun ' . config('app.name', 'Harimu'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.auth.reset-password',
            with: [
                'preheader' => 'Klik tautan untuk membuat kata sandi baru. Abaikan email ini jika bukan Anda yang meminta.',
                'name' => $this->userName,
                'action_url' => $this->actionUrl,
                'expire_minutes' => $this->expireMinutes,
                'request_ip' => $this->requestIp,
                'request_time' => $this->requestTime,
            ],
        );
    }
}
