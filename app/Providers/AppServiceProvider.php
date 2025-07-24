<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        
    }


    public function boot(): void
    {
    Relation::morphMap([
        'reels' => \App\Models\reels::class,
        'reel_comments' => \App\Models\reel_comments::class,
        'reel' => \App\Models\reels::class,
        'product' => \App\Models\product::class,
        'story' => \App\Models\Story::class,
    ]);
    }
}
