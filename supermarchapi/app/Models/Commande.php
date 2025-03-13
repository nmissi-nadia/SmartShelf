<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
  {
      protected $fillable = ['prix_total', 'user_id','produit_id'];
  
      public function user()
      {
          return $this->belongsTo(User::class);
      }
  }
