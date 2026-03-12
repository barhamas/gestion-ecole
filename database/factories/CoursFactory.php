<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CoursFactory extends Factory
{
    public function definition(): array
    {
        return [
            'libelle'        => $this->faker->words(3, true),
            'professeur'     => $this->faker->name(),
            'volume_horaire' => $this->faker->numberBetween(10, 60),
        ];
    }
}
