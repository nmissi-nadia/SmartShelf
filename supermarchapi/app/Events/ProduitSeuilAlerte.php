<?php

namespace App\Events;

use App\Models\Produit;
use Illuminate\Foundation\Events\Dispatchable;

class ProduitSeuilAlerte
{
    use Dispatchable;

    public $produit;

    public function __construct(Produit $produit)
    {
        $this->produit = $produit;
    }
}