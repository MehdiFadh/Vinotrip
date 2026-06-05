<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuppressionDonneeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function build(){
        return $this->from('vinotrip1@gmail.com')
                    ->subject('Demande suppression données personnelles')
                    ->view('emails.suppressionDonneePersonnel')
                    ->with(['client' => $this->client]);
    }
}
