<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Story;

class DeleteExpiredStories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-stories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expired = Story::where('expires_at', '<', now())->get();
        foreach ($expired as $story) {
            // حذف الصورة من storage
            Storage::disk('public')->delete($story->media);
            $story->delete();
        }
        $this->info('Expired stories deleted.');
    }
}
