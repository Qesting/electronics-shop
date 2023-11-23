<?php

namespace Database\Factories;

use App\Models\Users;
use App\Models\Orders;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        return [
            'first_name'=>Str::random(10),
            'last_name'=>Str::random(10),
            'email_address'=>Str::random(15)."@".Str::random(10),
            'phone_number'=>Str::random(15),

        ];
    }
        public function configure(): CustomerFactory
    {
        return $this->afterMaking(function (Customer $customer) {
            $address = Address::inRandomOrder()->first();
            $customer->address()->associate($address)->save();
        });
    }
}
