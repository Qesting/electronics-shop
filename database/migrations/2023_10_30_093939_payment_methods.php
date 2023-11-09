<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PaymentMethod;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $methodNames = [
            'Przelew internetowy',
            'Blik',
            'Przelew tradycyjny',
            'Pobranie'
        ];

        foreach ($methodNames as $methodName) {
            $method = new PaymentMethod;
            $method->name = $methodName;
            $method->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['payment_method_id']);
        });
        PaymentMethod::truncate();
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
        });
    }
};
