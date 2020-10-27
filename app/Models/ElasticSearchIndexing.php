<?php

namespace App\Models;

use App\Repositories\ESRepository;
use Illuminate\Support\Facades\Config;

trait ElasticSearchIndexing
{
    public static function bootElasticSearchIndexing()
    {
        if (Config::get('services.elasticsearch.enabled')) {
            static::observe(ESRepository::class);
        }
    }

    abstract public function getESIndex();

    abstract public function getESBody();
}
