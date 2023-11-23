<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'rating'=>rand(1,6),
            'content' => Str::random(100)
        ];
    }
    public function configure(): ProductReviewFactory
    {
        return $this->afterMaking(function (ProductReview $productreview) {
            $users = User::inRandomOrder()->first();
            $productreview->user()->associate($users)->save();
        });
    }
    public function configure2(): ProductReviewFactory
    {
        return $this->afterMaking(function (ProductReview $productreview) {
            $products = Product::inRandomOrder()->first();
            $productreview->product()->associate($products)->save();
        });
    }

}
