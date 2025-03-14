<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom', 
        'prix', 
        'quantite', 
        'pourcentage_sold', 
        'en_promotion', 
        'categorie_id'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function mettreAJourStock(int $quantite)
    {
        $this->quantite -= $quantite;
        $this->save();
    }
}
