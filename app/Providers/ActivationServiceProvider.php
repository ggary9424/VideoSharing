<?php

namespace App\Providers;

use App\Activation\ActivationService;
use App\Activation\ActivationRepository;
use Illuminate\Support\ServiceProvider;

class ActivationServiceProvider extends ServiceProvider
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
        $this->app->singleton('ActivationService', function($app) {
            return new ActivationService($app->make('Mailer'), new ActivationRepository());
        });
    }
}