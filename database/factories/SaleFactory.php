<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3, false),
            'description' => fake()->text(200),
            'expires_at' => Carbon::today()->addDays(30),
        ];
    }

    public function configure(): SaleFactory
    {
        return $this->afterCreating(function (Sale $sale) {
            $products = Product::inRandomOrder()->take(rand(1, 20))->get('id');
            $parsedProducts = collect();
            $products->each(function ($product) use ($parsedProducts) {
                $parsedProducts->put($product->id, [
                    'price' => rand(1E+2, 2E+3) / 100
                ]);
            });
            $sale->products()->attach($parsedProducts);
            $sale->save();
        });
    }
}
