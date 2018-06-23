<?php

namespace App\Mail;

use App\Person;
use App\Photo;
use App\Rightholder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestSignatureRightholder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    Public $rhConsent;
    Public $email_text;
    Public $email_from;
    Public $email_photo;


    public function __construct($rhConsent,$text,$from)
    {
        $this->rhConsent = $rhConsent;
        $this->email_text = $text;
        $this->email_from = $from;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->from('usuarios@allowapp.com')
                    ->markdown('emails.signature_rightholder');
    }
}
