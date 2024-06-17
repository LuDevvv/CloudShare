<?php

namespace App\Providers;

use App\Models\Upload;
use Illuminate\Support\ServiceProvider;
use App\Models\Video;
use App\Observers\VideoObserver;

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
        Upload::observe(VideoObserver::class);
    }
}
