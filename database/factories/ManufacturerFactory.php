<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manufacturer>
 */
class ManufacturerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'eu_tax_id' => fake()->countryCode() . str_pad(rand(0, 1E+9), 10, '0'),
        ];
    }

    public function configure(): ManufacturerFactory
    {
        return $this->afterMaking(function (Manufacturer $manufacturer) {
            $address = Address::inRandomOrder()->first();
            $manufacturer->address()->associate($address);
        });
    }
}
