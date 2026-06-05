<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ValidationPartenaireMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($numcommande, $dateDebut, $nomclient)
    {
        $this->numcommande = $numcommande;
        $this->dateDebut = $dateDebut;
        $this->nomclient = $nomclient;
    }

    public function build()
    {
        return $this->from('vinotrip1@gmail.com')
        ->subject('Validation du séjour')
        ->view('emails.validationPartenaire')
        ->with([ "numcommande" => $this->numcommande,
                "dateDebut" => $this->dateDebut,
                "nomclient" => $this->nomclient]);
    }

}
