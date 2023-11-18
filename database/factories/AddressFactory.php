<?php

namespace Database\Factories;

use Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'province' => Str::random(10),
            'country' => Str::random(10),
            'county' => Str::random(10),
            'city' => Str::random(10),
            'postal_code'=> rand(10,99)."-".rand(100,999),
            'street' => Str::random(20),
            'building' => rand(1,999),
            'apartment' => rand(1,999),

        ];
    }
}
