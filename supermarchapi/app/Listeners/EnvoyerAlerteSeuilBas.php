<?php

namespace App\Listeners;

use App\Events\ProduitSeuilAlerte;
use App\Notifications\StockAlertNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AlerteSeuilBas; 

class EnvoyerAlerteSeuilBas
{
    public function handle(StockCritiqueEvent $event)
{
    // Get the product from the event
    $produit = $event->produit;

    // Get all admins
    $admins = User::where('role', 'admin')->get();

    // Send an email to each admin
    foreach ($admins as $admin) {
        Mail::to($admin->email)->send(new AlerteSeuilBas($produit));
    }
}
}