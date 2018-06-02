<?php

namespace App\Mail;

use App\Person;
use App\Photo;
use App\Rightholder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestSignature extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    Public $rightholderphoto;
    Public $email_text;
    Public $email_from;
    Public $email_photo;


    public function __construct($rhp,$text,$from,$photo)
    {
        $this->rightholderphoto = $rhp;
        $this->email_text = $text;
        $this->email_from = $from;
        $this->email_photo = $photo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->from('usuarios@allowapp.com')
                    ->markdown('emails.signature');
    }
}
