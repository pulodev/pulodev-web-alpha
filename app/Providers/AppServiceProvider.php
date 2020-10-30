<?php

namespace App\Providers;

use App\Repositories\ElasticLinkRepositoryImpl;
use App\Repositories\Interfaces\LinkRepository;
use App\Repositories\LinkRepositoryImpl;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LinkRepository::class, function ($app) {
            if (!Config::get('services.elasticsearch.enabled')) {
                return new LinkRepositoryImpl();
            }

            return new ElasticLinkRepositoryImpl($app->make(Client::class));
        });

        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts([Config::get('services.elasticsearch.host')])
                ->build();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
