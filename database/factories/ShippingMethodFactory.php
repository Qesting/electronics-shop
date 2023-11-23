<?php
namespace Database\Factories;

use App\Models\Shipper;
use App\Models\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ShippingMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $minDays = rand(1,30);
        return [
            'name' => fake()->sentence(3, false),
            'min_days' => $minDays,
            'max_days' => rand($minDays, 56),
            'fee' => rand(1E+2, 2E+3) / 100,
        ];
    }
    public function configure(): ShippingMethodFactory
    {
        return $this->afterMaking(function (ShippingMethod $shippingMethod) {
            $shipper = Shipper::inRandomOrder()->first();
            $shippingMethod->shipper()->associate($shipper);
        });
    }
}
