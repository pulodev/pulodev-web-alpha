<?php

namespace App\Repositories;

use App\Models\Link;
use App\Repositories\Interfaces\LinkRepository;

class LinkRepositoryImpl implements LinkRepository
{
    public function search($query = '')
    {
        $links = Link::whereRaw('MATCH (title, body) AGAINST (?)', array($query))
            ->where('draft', 0)->orderBy('id', 'desc')->get();

        $aggregations = [];
        $content = [];
        foreach ($links as $link) {
            if (!in_array($link->media, $aggregations)) {
                $aggregations[] = $link->media;
            }

            $content[] = $link;
        }

        return compact('content', 'aggregations');
    }
}
