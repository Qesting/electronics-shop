<?php

use Illuminate\Database\Migrations\Migration;

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
        PaymentMethod::truncate();
    }
};
