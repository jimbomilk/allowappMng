<?php

namespace App\Mail;

use App\Person;
use App\Photo;
use App\Rightholder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PersonEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    Public $person;
    Public $title;
    Public $text;


    public function __construct($person,$title,$text)
    {
        $this->$person = $person;
        $this->$title = $title;
        $this->$text = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->from('usuarios@allowapp.com')
                    ->markdown('emails.person');
    }
}
