<?php

namespace App\Mail;

use App\Person;
use App\Photo;
use App\Rightholder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PhotoEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $element;
    public $title;
    public $text;
    public $from_;


    public function __construct($photo,$title,$text,$from)
    {

        $this->element = $photo;
        $this->title = $title;
        $this->text = $text;
        $this->from_= $from;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('usuarios@allowapp.com')
            ->markdown('emails.photo');

    }
}
