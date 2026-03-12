<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EtudiantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'prenom'         => $this->faker->firstName(),
            'nom'            => $this->faker->lastName(),
            'email'          => $this->faker->unique()->safeEmail(),
            'date_naissance' => $this->faker->date('Y-m-d', '2005-01-01'),
        ];
    }
}
