<?php

namespace Database\Factories;

use App\Models\User;
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
            'type'         => fake()->randomElement(['Car', 'Truck', 'Motorcycle']),
            'brand'        => fake()->randomElement(['Toyota', 'Honda', 'Ford', 'Mitsubishi', 'Hyundai']),
            'color'        => fake()->safeColorName(),
            'model'        => fake()->word(),
            'plate_number' => strtoupper(fake()->bothify('???-####')), // e.g. ABC-1234
            'registered_by' => User::factory(),
        ];
    }
}
