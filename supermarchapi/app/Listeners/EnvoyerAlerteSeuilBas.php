<?php

namespace App\Listeners;

use App\Events\ProduitSeuilAlerte;
use App\Notifications\StockAlertNotification;
use App\Models\User;

class EnvoyerAlerteSeuilBas
{
    public function handle(ProduitSeuilAlerte $event)
    {
        // Récupérer tous les administrateurs
        $admins = User::where('role', 'admin')->get();

        // Envoyer une notification à chaque admin
        foreach ($admins as $admin) {
            $admin->notify(new StockAlertNotification($event->produit));
        }
    }
}