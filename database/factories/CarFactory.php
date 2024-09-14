<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'make' => $this->faker->userName(),
            'model' => $this->faker->userName,
            'year' => $this->faker->year(),
            'color' => $this->faker->colorName(),
            'license_plate' => $this->faker->isbn13(),
        ];
    }
}
