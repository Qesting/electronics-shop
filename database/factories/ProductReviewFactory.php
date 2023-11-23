<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating'=>rand(1,5),
            'content' => fake()->text(200)
        ];
    }
    public function configure(): ProductReviewFactory
    {
        return $this->afterMaking(function (ProductReview $productReview) {
            $user = User::inRandomOrder()->first();
            $product = Product::inRandomOrder()->first();

            $productReview->user()->associate($user);
            $productReview->product()->associate($product);
        });
    }
}
