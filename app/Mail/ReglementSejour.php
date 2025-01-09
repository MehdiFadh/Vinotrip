<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReglementSejour extends Mailable
{
    use Queueable, SerializesModels;

    public $commandeEffectif;
    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->from('vinotrip1@gmail.com')
                    ->subject('Règlement séjour')
                    ->view('emails.reglementSejour');
    }
}
