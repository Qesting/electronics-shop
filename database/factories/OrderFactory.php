<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Customer;
use App\Models\ShippingMethod;
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
            //'payment_method_id'=>
            //'shipping_method_id'=>
            'completed'=>rand(0,1)
        ];
    }

    public function configure(): OrderFactory
    {
        return $this->afterMaking(function (Order $order) {
            $customer = Customer::inRandomOrder()->first();
            $order->customer()->associate($customer)->save();
        });
    }

    public function configure2(): OrderFactory
    {
        return $this->afterMaking(function (Order $order) {
            $PaymentMethod = PaymentMethod::inRandomOrder()->first();
            $order->paymentMethod()->associate($PaymentMethod)->save();
        });
    }

    public function configure3(): OrderFactory
    {
        return $this->afterMaking(function (Order $order) {
            $shippingMethod = ShippingMethod::inRandomOrder()->first();
            $order->ShippingMethod()->associate($shippingMethod)->save();
        });
    }

}
