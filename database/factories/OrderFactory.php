<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\ShippingMethods;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total'=> rand(1/100,30000/100),
            'dicount_code_id'=>rand(1,999),
            //'customer_id'=>
            //'payment_method_id'=>
            //'shipping_method_id'=>
            'completed'=>rand(0,1)
        ];
    }
}
