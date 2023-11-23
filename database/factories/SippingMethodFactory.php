<?php
namespace Database\Factories;

use App\Models\Order;
use App\Models\Shipper;
use App\Models\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SippingMethodFactory extends Factory
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
            'min_days'=>rand(1,30),
            'max_days'=>rand(31,56),
            'fee'=>rand(10/100,2000/100),
        ];
    }
    public function configure(): SippingMethodFactory
    {
        return $this->afterMaking(function (ShippingMethod $sippingMethod) {
            $sippers = Shipper::inRandomOrder()->first();
            $sippingMethod->user()->associate($sippers)->save();
        });
    }
}
