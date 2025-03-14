<?php

namespace Database\Factories;

use App\Models\Categorie;
use App\Models\Rayon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorieFactory extends Factory
{
    protected $model = Categorie::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->unique()->word(),
            'rayon_id' => \App\Models\Rayon::factory(), // Assuming you have a Rayon model
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}