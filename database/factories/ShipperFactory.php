<?php

namespace Database\Factories;

use App\Models\Shipper;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ShipperFactory extends Factory
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

    public function configure(): ShipperFactory
    {
        return $this->afterMaking(function (Shipper $shipper) {
            $address = Address::inRandomOrder()->first();
            $shipper->address()->associate($address);
        });
    }
}
