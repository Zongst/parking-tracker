<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ParkingSession>
 */
class ParkingSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $entry = fake()->dateTimeBetween('-7 days', 'now');
        $exit = (clone $entry)->modify('+'.rand(15, 180).' minutes');

        return [
            'vehicle_id' => \App\Models\Vehicle::factory(),
            'entry_time' => $entry,
            'exit_time' => $exit,
            'duration_minutes' => $exit ? $entry->diff($exit)->i + $entry->diff($exit)->h * 60 : null,
            'status' => 'completed',
        ];
    }
}
