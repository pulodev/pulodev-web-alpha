<?php

namespace App\Repositories;

use Elasticsearch\Client;

class ESRepository
{
    /**
     * @var \Elasticsearch\Client
     */
    private $esClient;

    public function __construct(Client $esClient)
    {
        $this->esClient = $esClient;
    }

    public function saved($model)
    {
        $this->esClient->index([
            'index' => $model->getESIndex(),
            'id' => $model->id,
            'body' => $model->getESBody()
        ]);
    }

    public function deleted($model)
    {
        $this->esClient->delete([
            'index' => $model->getEsIndex(),
            'id' => $model->id
        ]);
    }
}
