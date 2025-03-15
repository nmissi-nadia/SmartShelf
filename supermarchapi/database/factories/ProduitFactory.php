<?php

namespace Database\Factories;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProduitFactory extends Factory
{
    protected $model = Produit::class; // Lie la factory au modèle

    public function definition()
    {
        return [
            'nom' => $this->faker->word(),
            'prix' => $this->faker->randomFloat(2, 10, 100),
            'quantite' => $this->faker->numberBetween(1, 100),
            'pourcentage_sold' => null,
            'en_promotion' => false,
            'categorie_id' => Categorie::factory(), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
