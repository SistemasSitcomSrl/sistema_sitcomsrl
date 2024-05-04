<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_equipment' => $this->faker->word,
            'bar_Code' => $this->faker->unique()->randomNumber,
            'brand' => $this->faker->word,
            'color' => $this->faker->colorName,
            'amount' => 100,
            'location' => $this->faker->randomNumber(2),
            'unit_measure' => $this->faker->word,
            'price' => $this->faker->randomFloat(0, 10, 1000),
            'type' => $this->faker->randomElement(['Material', 'Activo', 'Herramienta']),
            'state' => 1,
            'branch_id' => $this->faker->numberBetween(1, 3)
        ];
    }
}
