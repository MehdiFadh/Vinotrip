<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DemandeAvisHotelMail extends Mailable
{
    use Queueable, SerializesModels;

    public $hotelChoisi;

    public function __construct($hotelChoisi)
    {
        $this->hotelChoisi = $hotelChoisi;
    }

    public function build()
    {
        return $this->from('vinotrip1@gmail.com')
                    ->subject('Demande d\'avis sur le nouvel hôtel choisi')
                    ->view('emails.demandeAvisHotel')
                    ->with(['hotel' => $this->hotelChoisi]);
    }
}
