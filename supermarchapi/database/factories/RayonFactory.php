<?php

namespace Database\Factories;

use App\Models\Rayon;
use Illuminate\Database\Eloquent\Factories\Factory;

class RayonFactory extends Factory
{
    protected $model = Rayon::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'qte_max' => $this->faker->randomDigit(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
