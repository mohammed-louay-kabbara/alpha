<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Story;
use Carbon\Carbon;

class DeleteExpiredStories extends Command
{
    protected $signature = 'stories:delete-expired';
    protected $description = 'Deletes stories older than 24 hours';

    public function handle()
    {
        $expiredStories = Story::expired()->get();

        foreach ($expiredStories as $story) {
            // حذف الصورة من التخزين إذا كانت موجودة
            if ($story->image_path) {
                \Storage::delete($story->image_path);
            }

            // حذف القصة من قاعدة البيانات
            $story->delete();
        }

        $this->info("Deleted " . count($expiredStories) . " expired stories.");
    }
}
