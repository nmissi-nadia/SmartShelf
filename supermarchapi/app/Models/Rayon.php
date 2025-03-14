<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Rayon extends Model
{
    use Sluggable;
    protected $fillable = [
        'nom',
        'description',
        'qte_max'
    ];
    public function sluggable(): array
    {
        return ['slug' => ['source' => 'nom']];
    }
}
