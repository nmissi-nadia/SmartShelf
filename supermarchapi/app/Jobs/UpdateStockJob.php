<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Produit;

class UpdateStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $produit;
    public $quantiteVendue;

    public function __construct(Produit $produit, int $quantiteVendue)
    {
        $this->produit = $produit;
        $this->quantiteVendue = $quantiteVendue;
    }

    public function handle()
    {
        // Mettre à jour la quantité du produit
        $nouvelleQuantite = $this->produit->quantite - $this->quantiteVendue;
        $this->produit->update(['quantite' => $nouvelleQuantite]);

        // Vérifier si le produit passe sous le seuil d'alerte
        $seuilAlerte = 5; // Seuil fixe ou récupéré depuis une configuration
        if ($nouvelleQuantite <= $seuilAlerte) {
            event(new \App\Events\ProduitSeuilAlerte($this->produit));
        }
    }
}