<?php

namespace App\Mail;

use App\Person;
use App\Photo;
use App\Rightholder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RightholderEmail extends Mailable
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
    public $consents;


    public function __construct($rightholder,$title,$text,$from,$consents)
    {

        $this->element = $rightholder;
        $this->title = $title;
        $this->text = $text;
        $this->from_= $from;
        $this->consents = $consents;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('usuarios@allowapp.com')
            ->markdown('emails.rightholder');

    }
}
