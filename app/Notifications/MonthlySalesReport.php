<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Storage;

class MonthlySalesReport extends Notification implements ShouldQueue
{
    use Queueable;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Rapport Mensuel des Ventes')
            ->line('Veuillez trouver ci-joint le rapport mensuel des ventes.')
            ->attach($this->filePath, [
                'as' => 'Rapport_Ventes.pdf',
                'mime' => 'application/pdf',
            ])
            ->line('Merci pour votre attention.');
    }
}
