<?php

namespace App\Console;

use App\Models\DiscountCode;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        /**
         * Soft delete expired sales and discount codes.
         */
        $schedule->call(function () {
            $expiredSales = Sale::whereDate(
                    'expires_at',
                    '<=',
                    Carbon::now()->toDateString()
            )->get();
            $expiredSales->each(function (Sale $sale) {
                $sale->delete();
            });

            $expiredCodes = DiscountCode::whereDate(
                'expires_at',
                '<=',
                Carbon::now()->toDateString()
            )->get();
            $$expiredCodes->each(function (DiscountCode $code) {
                $code->delete();
            });
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
