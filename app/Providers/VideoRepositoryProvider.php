<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use app\VideoRepository;
use app\Models\Video;

class VideoRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('VideoRepository', function ($app) {
            return new VideoRepository(new Video);
        }

    }
}
