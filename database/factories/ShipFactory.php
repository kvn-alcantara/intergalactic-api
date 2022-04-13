<?php

namespace Database\Factories;

use App\Models\Pilot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ShipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'pilot_id' => Pilot::factory(),
            'fuel_capacity' => $this->faker->numberBetween(100, 500),
            'fuel_level' => $this->faker->numberBetween(0, 500),
            'weight_capacity' => $this->faker->numberBetween(100, 200),
        ];
    }
}
