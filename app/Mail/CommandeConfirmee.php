<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommandeConfirmee extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;

    public function __construct($commande)
    {
        $this->commande = $commande;
    }

    public function build()
    {
        return $this->subject('Votre séjour est confirmé')
            ->view('emails.commande_confirmee');
    }

    use App\Mail\CommandeConfirmee;
    use Illuminate\Support\Facades\Mail;

    protected function envoyerMailClient($commande)
    {
        Mail::to($commande->user->email)->send(new CommandeConfirmee($commande));
    }

}

