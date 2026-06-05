<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DisponibiliteTousHotelMail extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct()
    {
        //
    }
    public function build()
    {
        return $this->from('vinotrip1@gmail.com')
                    ->subject('Vérification disponibilité')
                    ->view('emails.tousdisponibilite');
    }

}
