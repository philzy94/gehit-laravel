<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $emailVerification;

    public function __construct($emailVerification)
    {
        $this->emailVerification = $emailVerification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no_reply@gehit.com', 'Gheit')
        ->subject('Verify Email')->view('emails.verifyEmail')->with([
            'emailVerificationLink' => $this-> emailVerification,            
        ]);
    }
}
