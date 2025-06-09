<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // جدولة حذف الحالات بعد 24 ساعة
       $schedule->call(function () {
        \App\Models\Story::where('created_at', '<', now()->subHours(24))->delete();
    })->everyTenMinutes(); // مثلاً كل دقيقة، عدّله لاحقًا إن أردت
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
