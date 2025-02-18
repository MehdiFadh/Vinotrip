<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DisponibiliteHotelMail extends Mailable
{
    use Queueable, SerializesModels;

    public $commandeEffectif;

    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->from('vinotrip1@gmail.com')
                    ->subject('Vérification disponibilité')
                    ->view('emails.disponibilite');
    }

    
}
