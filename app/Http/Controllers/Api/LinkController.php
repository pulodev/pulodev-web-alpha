<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Link;
use App\Models\Resource;
use App\Rules\MinimalWords;
use Illuminate\Http\Request;

class LinkController extends AbstractApiController
{
    /**
     * add new link
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'rss_id' => 'required',
            'items' => 'required|array',
            'items.link.*' => 'required',
            'items.title.*' => ['required', 'max:255', new MinimalWords(2)],
            'items.description.*' => ['required', new MinimalWords(5)],
        ]);

        //check rss_id to get value of "media" and "user_id"
        $rss = Resource::findOrFail($request->rss_id);
        $report = [];
        $anyDataAdded = false;
        
        foreach($request->items as $item) {
            $isAllowedToSave = true;

            if(!isValidUrl($item['link'])) {
                $isAllowedToSave = false;
                $report[$item['link']] = 'url is not valid. url should be like this "https://pulo.dev/content-page"';
            }
            
            $cleanedUrl = cleanUrl($item['link']);
            $existedUrl = Link::where('url', $cleanedUrl)->first();
            if ($existedUrl) {
                $isAllowedToSave = false;
                $report[$item['link']] = 'link already exist';
            }

            if($isAllowedToSave) {
                $link = Link::create([
                    'title' => $item['title'],
                    'url'  => $cleanedUrl,
                    'slug'  => generateSlug($item['title'], new Link),
                    'body'  => $item['description'],
                    'tags'  => $item['tags'] ?? '',
                    'owner'  => ($item['owner'] != '' && $item['owner'] != '-' ) ? $item['owner'] : $rss->title,
                    'media'  => $rss->media,
                    'user_id' => $rss->user_id,
                    'original_published_at'  => $item['pubDate'] ?? Carbon::now(),
                ]);  

                if ($link) {
                    $anyDataAdded = true;
                } else {
                    $report[$item['link']] = 'failed on saving data';
                }

                //TODO: write to logfile if add link failed
            }
        }

        if ($anyDataAdded) {
            $rssUpdate = $rss->update([
                'last_checked_at' => Carbon::now()
            ]);

            //TODO: write to logfile if rss update failed
        }
        
        if (sizeof($report) !== 0 ) {
            return $this->responseNOK('there is some error on add link!', $report);
        } else {
            return $this->responseOK();
        }
    }
}
