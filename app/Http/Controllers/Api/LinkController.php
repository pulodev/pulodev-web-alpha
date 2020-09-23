<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Link;
use App\Rules\MinimalWords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
            'link' => 'required',
            'title' => ['required', 'max:255', new MinimalWords(2)],
            'description' => ['required', new MinimalWords(5)],
            'tags' => 'required',
        ]);

        $isUrlExist = Link::where('url', $request->link)->first();
        if ($isUrlExist) {
            return $this->responseNOK('link already exist');
        }
        
        $user = Auth::user();
        $link = $user->links()->create([
            'title' => $request->title,
            'url'  => $request->link, //todo: clean up url first
            'slug'  => generateSlug($request->title, new Link),
            'body'  => $request->description,
            'tags'  => $request->tags,
            'media'  => $request->media ?? '',
            'owner'  => $request->owner,
            'draft' => $user->isAdmin() ? false : true, //if admin auto publish
            'original_published_at'  => $request->publishDate ?? Carbon::now(),
        ]);  

        if ($link) {
            return $this->responseOK();
        }

        return $this->responseNOK('input link failed!');
    }
}
