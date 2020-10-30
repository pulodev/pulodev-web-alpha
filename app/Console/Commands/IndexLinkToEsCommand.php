<?php

namespace App\Console\Commands;

use App\Models\Link;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class IndexLinkToEsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'link:es_index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all links to elasticsearch';
    
    /** @var \Elasticsearch\Client */
    private $esClient;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $esClient)
    {
        parent::__construct();

        $this->esClient = $esClient;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('start indexing all links data to elasticsearch.\n');

        foreach(Link::cursor() as $link) {
            if($link->deleted_at || $link->draft == 1) {
                continue;
            }

            $this->esClient->index([
                'index' => $link->getESIndex(),
                'id' => $link->id,
                'body' => [
                    'title' => $link->title,
                    'slug' => $link->slug,
                    'body' => $link->body,
                    'owner' => $link->owner,
                    'media' => $link->media,
                    'tags' => explode(',', $link->tags),
                    'updated_at' => $link->updated_at,
                    'original_published_at' => $link->original_published_at,
                    'created_at' => $link->created_at,
                    'user' => [
                        'username' => $link->user->username,
                        'fullname' => $link->user->fullname,
                        'avatar_url' => $link->user->avatar_url,
                    ],
                ]
            ]);

            $this->info("added " . $link->title);
        }

        $this->info("\n done import all links to elastichsearch!");
        return 0;
    }
}
