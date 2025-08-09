<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Story;
use Carbon\Carbon;

class DeleteExpiredStories extends Command
{

    protected $signature = 'stories:delete-old';
    protected $description = 'حذف الستوري الذي مر عليه أكثر من 24 ساعة';

    public function handle()
    {
        $deleted = Story::where('created_at', '<', Carbon::now()->subHours(24))->delete();
        $this->info("تم حذف {$deleted} ستوري قديمة.");
    }
}
