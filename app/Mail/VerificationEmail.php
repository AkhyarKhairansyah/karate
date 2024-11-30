<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class VerificationEmail extends Mailable
{
    public $verificationCode;

    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    public function build()
    {
        return $this->subject('Verifikasi Email Anda')
                    ->view('emails.verification');
    }
}

