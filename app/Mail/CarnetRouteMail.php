<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CarnetRouteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($numcommande, $destination, $nomclient, $hotelChoisi )
    {
        $this->hotelChoisi = $hotelChoisi;
        $this->nomclient = $nomclient;
        $this->destination = $destination;
        $this->numcommande = $numcommande;
    }

    public function build()
    {
        return $this->from('vinotrip1@gmail.com')
                    ->subject('Carnet de Route')
                    ->view('emails.carnetRoute')
                    ->with(['hotel' => $this->hotelChoisi,
                            'nomclient' => $this->nomclient,
                            'destination' => $this->destination,
                            'numcommande' => $this->numcommande]);
    }
}
