<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $gender = ['M', 'F'][rand(0, 1)];
        return [
            'first_name' => fake()->firstName($gender),
            'last_name' => fake()->lastName($gender),
            'email_address' => fake()->email(),
            'phone_number' => fake()->phoneNumber(),
        ];
    }
        public function configure(): CustomerFactory
    {
        return $this->afterMaking(function (Customer $customer) {
            $address = Address::inRandomOrder()->first();
            $customer->address()->associate($address);
        });
    }
}
