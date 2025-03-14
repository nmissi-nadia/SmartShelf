<?php
namespace App\Notifications;

use App\Models\Produit;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StockAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $produit;

    public function __construct(Produit $produit)
    {
        $this->produit = $produit;
    }

    public function via($notifiable)
    {
        return ['mail']; // Utilisez 'database' si vous voulez stocker les notifications en base
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Alerte de stock critique")
            ->line("Le produit {$this->produit->nom} a atteint un niveau critique de stock.")
            ->line("Quantité restante : {$this->produit->quantite}")
            ->action('Voir les détails', url('/admin/produits/' . $this->produit->id))
            ->line('Merci de réapprovisionner rapidement.');
    }
}