<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'total'=> rand(1E+2, 3E+6) / 100,
            'completed'=>rand(0,1)
        ];
    }

    public function configure(): OrderFactory
    {
        return $this->afterMaking(function (Order $order) {
            $customer = Customer::inRandomOrder()->first();
            $paymentMethod = PaymentMethod::inRandomOrder()->first();
            $shippingMethod = ShippingMethod::inRandomOrder()->first();

            $order->customer()->associate($customer);
            $order->paymentMethod()->associate($paymentMethod);
            $order->shippingMethod()->associate($shippingMethod);

            if (rand(0, 1)) {
                $discountCode = DiscountCode::inRandomOrder()->first();
                $order->discountCode()->associate($discountCode);
            }
        })->afterCreating(function (Order $order) {
            $products = Product::inRandomOrder()->take(rand(1, 20))->get('id');
            $parsedProducts = collect();
            $products->each(function ($product) use ($parsedProducts) {
                $parsedProducts->put($product->id, [
                    'quantity' => rand(1, 20),
                    'returned' => rand(0, 1)
                ]);
            });
            $order->products()->attach($parsedProducts);
            $order->save();
        });
    }
}
