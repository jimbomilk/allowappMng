<?php

namespace App\Mail;

use App\Person;
use App\Photo;
use App\Rightholder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OnlyPhotoEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $url;
    public $route;
    public $title;
    public $text;
    public $from_;


    public function __construct($url,$route,$title,$text,$from)
    {

        $this->url = $url;
        $this->route = $route;
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
            ->markdown('emails.onlyphoto');

    }
}
