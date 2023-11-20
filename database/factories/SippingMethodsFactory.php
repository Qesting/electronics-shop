<?php
namespace Database\Factories;

use App\Models\Order;
use App\Models\Shipper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SippingMethodsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::random(15),
            //'shipper_id' =>
            'min_days'=>rand(1,30),
            'max_days'=>rand(31,56),
            //'fee'=>
        ];
    }
}
