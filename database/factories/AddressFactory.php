<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country' => fake()->country(),
            'city' => fake()->city(),
            'postal_code'=> fake()->postcode(),
            'street' => fake()->streetName(),
            'building' => rand(1,999),
            'apartment' => rand(0, 1) ? rand(1,999) : null,
        ];
    }
}
