<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'name' => Str::random(30),
            'eu_tx_id'=> rand(1,1000)
        ];
    }
    public function configure(): ManufacturerFactory
    {
        return $this->afterMaking(function (Manufacturer $manufacturer) {
            $address = Address::inRandomOrder()->first();
            $manufacturer->address()->associate($address)->save();
        });
    }
}
