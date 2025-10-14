<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'warehouse_id'   => '1',
            'category'    => fake()->randomElement(['material', 'tool']),
            'name'        => fake()->word(),
            'description' => fake()->sentence(),
            'cost'        => fake()->numberBetween(100, 1000),
            'measure'     => fake()->randomElement(['kg', 'ton', 'pc']),
            'stocks'      => fake()->numberBetween(1, 10),
        ];
    }
}
