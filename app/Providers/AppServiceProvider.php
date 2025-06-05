<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
           Relation::morphMap([
        'reels' => \App\Models\reels::class,
        // 'Product' => \App\Models\Product::class,
    ]);
    }
}
