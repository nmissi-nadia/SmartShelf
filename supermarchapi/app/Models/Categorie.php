<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'rayon_id'];
  
      public function rayon()
      {
          return $this->belongsTo(Rayon::class);
      }
  
      public function produits()
      {
          return $this->hasMany(Produit::class);
      }
}
