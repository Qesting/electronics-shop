<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email_address' => fake()->email(),
            'password' => 'Test1234'
        ];
    }
    public function configure(): UserFactory
    {
        return $this->afterMaking(function (User $user) {
            $customer = Customer::whereDoesntHave('user')->inRandomOrder()->first();
            $user->customer()->associate($customer);
        });
    }
}
