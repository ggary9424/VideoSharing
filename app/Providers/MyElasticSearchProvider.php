<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Video;
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
        // We can hook into our Eloquent Model’s saved and deleted events to
        // keep Elasticsearch in sync with our database.
        $client = $this->app->make('MyElasticSearch');
        Video::saved(function ($video) use ($client) {
            $es_params = [
                'index' => 'videosharing_index',
                'type' => 'video',
                'id' => $video->id,
                'body' => [
                            'name' => $video->name,
                            'desc' => $video->desc,
                            'user' => $video->user()->first()->name,
                            'created_time' => $video->created_at->format('Y/m/d')
                          ]
            ];
            $client->index($es_params);
        });

        Video::deleted(function ($video) use ($client) {
            $es_params = [
                'index' => 'videosharing_index',
                'type' => 'video',
                'id' => $video->id
            ];
            $client->delete($es_params);
        });
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
