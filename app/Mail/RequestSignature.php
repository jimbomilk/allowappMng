<?php

namespace App\Mail;

use App\Person;
use App\Photo;
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
    Public $urlconforme;
    Public $urlnoconforme;
    Public $photo;
    Public $person;

    public function __construct(Person $person, $photo,$urlconforme,$urlnoconforme)
    {
        $this->urlconforme = $urlconforme;
        $this->urlnoconforme = $urlnoconforme;
        $this->photo = $photo;
        $this->person = $person;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->from('jmgarciacarrasco@addmeetoo.com')
                    ->markdown('emails.signature')
                    ->attach($this->photo);
    }
}
