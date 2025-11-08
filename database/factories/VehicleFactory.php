<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    return [
        'registration_number' => strtoupper(fake()->bothify('??## ???')),
        'make' => fake()->randomElement(
            ['Ford', 'Toyota', 'Tesla', 'BMW', 'Audi', 'Honda', 'Chevrolet', 'Nissan', 'Volkswagen', 'Hyundai']
        ),
        'model' => fake()->word(),
    ];
}
}
