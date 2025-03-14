<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model

  {
      use HasFactory;
      protected $fillable = ['prix_total', 'user_id','produit_id'];
  
      public function user()
      {
          return $this->belongsTo(User::class);
      }
  }
