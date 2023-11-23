<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Address::factory()->count(150)->create();
        \App\Models\Customer::factory()->count(100)->create();
        \App\Models\User::factory()->count(20)->create();
        \App\Models\Manufacturer::factory()->count(10)->create();
        \App\Models\Product::factory()->count(1000)->create();
        \App\Models\ProductReview::factory()->count(1000)->create();
        \App\Models\DiscountCode::factory()->count(10)->create();
        \App\Models\Sale::factory()->count(5)->create();
        \App\Models\Shipper::factory()->count(2)->create();
        \App\Models\ShippingMethod::factory()->count(4)->create();
        \App\Models\Order::factory()->count(40)->create();
    }
}
