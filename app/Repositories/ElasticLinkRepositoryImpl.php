<?php

namespace App\Repositories;

use App\Models\Link;
use App\Repositories\Interfaces\LinkRepository;
use Elasticsearch\Client;
use Illuminate\Support\Arr;
use stdClass;

class ElasticLinkRepositoryImpl implements LinkRepository
{
    /**
     * @var \Elasticsearch\Client
     */
    private $esClient;

    public function __construct(Client $esClient)
    {
        $this->esClient = $esClient;
    }

    public function search($query = '')
    {
        $link = new Link();

        $items = $this->esClient->search([
            'index' => $link->getESIndex(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ["title", "body", "tags", "media"],
                        'query' => $query,
                    ]
                ],
                'aggs' => [
                    'media' => [
                        'terms' => [
                            'field' => 'media.keyword'
                        ]
                    ]
                ]
            ]
        ]);

        $aggregations = $this->extractAggregations($items);
        $content = $this->extractContent($items);

        return compact('content', 'aggregations');
    }

    private function extractContent($items)
    {
        $arrContents = Arr::pluck($items['hits']['hits'], '_source');
        $links = [];

        foreach ($arrContents as $content) {
            $content['tags'] = implode(',', $content['tags']);

            $link = new Link($content);
            $link->user = $this->getUserObject($content);
            $links[] = $link;
        }

        return $links;
    }

    private function extractAggregations($items)
    {
        return Arr::pluck($items['aggregations']['media']['buckets'], 'key');
    }

    private function getUserObject($content)
    {
        $isUserDataExist = array_key_exists('user', $content);

        $userObj = new stdClass();
        $userObj->username = $isUserDataExist ? $content['user']['username'] : '-';
        $userObj->fullname = $isUserDataExist ? $content['user']['fullname'] : '-';
        $userObj->avatar_url = $isUserDataExist ? $content['user']['avatar_url'] : '-';

        return $userObj;
    }
}
