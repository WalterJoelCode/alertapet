<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'País de prueba '.fake()->unique()->numberBetween(1000, 9999),
            'iso_code' => fake()->unique()->lexify('??'),
        ];
    }
}
