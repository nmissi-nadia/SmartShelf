<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rayon extends Model
{
    use Sluggable;
    use HasFactory;
    protected $fillable = [
        'nom',
        'description',
        'qte_max'
    ];
    public function sluggable(): array
    {
        return ['slug' => ['source' => 'nom']];
    }
    // Relation : Un rayon a plusieurs catégories
    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }
}
