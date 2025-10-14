<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'     => fake()->company(),                // e.g. "Sunrise Supply Depot"
            'house'    => fake()->buildingNumber(),         // e.g. "123"
            'barangay' => fake()->streetName(),             // e.g. "Pine Street"
            'city'     => fake()->city(),                   // e.g. "Quezon City"
            'province' => fake()->state(),                  // e.g. "Metro Manila"
            'zipcode'  => fake()->postcode(),               // e.g. "1100"
        ];
    }
}
