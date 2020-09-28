<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Link;
use App\Models\Resource;
use App\Rules\MinimalWords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        foreach($request->items as $item) {
            if(!isValidUrl($item['link'])) 
                return $this->responseNOK('url is not valid. url should be like this "https://pulo.dev/content-page"');
            
            $cleanedUrl = cleanUrl($item['link']);
            $existedUrl = Link::where('url', $cleanedUrl)->first();
            if ($existedUrl) 
                return $this->responseNOK('link already exist');
            
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
                'original_published_at'  => $item['publishDate'] ?? Carbon::now(),
            ]);  
            
            $status = true;
            if (!$link)
                $status = false;
        }

        if ($status)
            return $this->responseOK();

        return $this->responseNOK('input link failed!');
    }
}
