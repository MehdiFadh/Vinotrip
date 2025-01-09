<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RemboursementClientMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($prixsejour)
    {
        $this->prixsejour = $prixsejour;
    }

    public function build(){
        return $this->from('vinotrip1@gmail.com')
                    ->subject('Remboursement séjour')
                    ->view('emails.remboursementClient')
                    ->with([ "prixsejour" => $this->prixsejour]);

    }

}
