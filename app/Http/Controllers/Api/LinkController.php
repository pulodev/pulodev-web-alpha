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

        $status = null;
        $linksStatus = [];
        $lastCheckedUpdated = false;
        foreach($request->items as $item) {
            if(!isValidUrl($item['link'])) {
                $status = [
                    'link'=>$item['link'],
                    'status'=> 'invalid'
                ];
            } else {
                $cleanedUrl = cleanUrl($item['link']);
                $existedUrl = Link::where('url', $cleanedUrl)->first();

                if ($existedUrl){
                    if(is_null($existedUrl->resource_id))
                        $this->updateLinkResource($existedUrl, $request->rss_id);

                    $status = [
                        'link'=>$item['link'],
                        'status'=> 'exist'
                    ];
                } else {
                    $user = Auth::user();
                    $link = $user->links()->create([
                        'title' => $item['title'],
                        'url'  => $cleanedUrl,
                        'slug'  => generateSlug($item['title'], new Link),
                        'body'  => $item['description'],
                        'tags'  => $item['tags'] ?? '',
                        'owner'  => $item['owner'] ?? '',
                        'media'  => $rss->media,
                        'user_id' => $rss->user_id,
                        'resource_id' => $rss->id,
                        'original_published_at'  => $item['publishDate'] ?? Carbon::now(),
                    ]);
                  
                    if($link &&){
                        $status = [
                            'link'=>$item['link'],
                            'status'=> 'success'
                        ];
                        if($lastCheckedUpdated===false){
                          
                            $rssUpdate = $rss->update([
                                'last_checked_at' => Carbon::now()
                            ]);
                            $lastCheckedUpdated = true;
                        }
                        //TODO: write to logfile if rss update failed
                      
                    } else {
                        $status = [
                        'link'=>$item['link'],
                        'status'=> 'failed'
                        ];
                    }

                    
                }
            }
            array_push($linksStatus,$status);
        }

        return $this->responseOK($linksStatus);
    }

    private function updateLinkResource(Link $link, $resource_id)
    {
        $link->resource_id = $resource_id;
        $link->save();
    }
}
