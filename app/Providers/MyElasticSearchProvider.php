<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Elasticsearch;

class MyElasticSearchProvider extends ServiceProvider
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
        $this->app->singleton('MyElasticSearch', function($app) {
            /* set hosts */
            $hosts = array(env('ES_HOST'));
            $client = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
            return $client;
        });
    }
}