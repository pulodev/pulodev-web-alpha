<?php

namespace App\Http\Controllers;

use OpenGraph;
use Carbon\Carbon;
use App\Models\Link;
use App\Rules\MinimalWords;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LinkController extends Controller
{
    
    public function create()
    {
        return view('link.create');
    }

    public function scrape(Request $request)
    {
        //add https if no prefix
        $linkInput = $this->checkFullUrl($request->url);

        //check if exists
        if(Link::where('url', $this->cleanUrl($linkInput))->exists()) 
            return response()->json(['status' => 'EXISTS', 'msg' => 'link sudah ada'], 403);

        $data =  OpenGraph::fetch($linkInput, true);

        //get thumbnail
        $thumbnail = '';
        $thumbnailPossibleMeta = ['image', 'twitter:image', 'twitter:image:src'];
        foreach($thumbnailPossibleMeta as $meta) {
            if(isset($data[$meta]) && $data[$meta] != ''){
                $thumbnail = $data[$meta];
                break;
            }
        }

        return response()->json([
            'title' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'author' => $data['author'] ?? '',
            'thumbnail' => $thumbnail,
            'original_published_at' => (isset($data['article:published_time'])) ? Carbon::parse($data['article:published_time'])->format('Y-m-d') : Carbon::now()
        ]);
    }

    private function checkFullUrl($url)
    {
        return parse_url($url, PHP_URL_SCHEME) === null ?
            'https://' . $url : $url;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required',
            'title' => ['required', 'max:255', new MinimalWords(2)],
            'body' => ['required', new MinimalWords(5)],
            'tags' => 'required',
        ]);

        $user = Auth::user();    
        
        $link = $user->links()->create([
            'title' => $request->title,
            'url'  => $this->cleanUrl($request->url),
            'slug'  => generateSlug($request->title, new Link),
            'body'  => $request->body,
            'tags'  => $request->tags,
            'media'  => $request->media,
            'owner'  => $request->owner,
            'thumbnail' => $request->thumbnail,
            'draft' => Auth::user()->isAdmin() ? false : true, //if admin auto publish
            'original_published_at'  => $request->original_published_at ?? Carbon::now(),
        ]);  

        //change session token
        $request->session()->regenerateToken();
        return redirect('/link/' . $link->slug)->with('success', 'Link berhasil disubmit. Akan kami review');
    }

    private function cleanUrl($url) {
        
        //remove question mark like utm_soruce etc...
        $parsedURL = parse_url($url);

        if(Str::contains($parsedURL['host'], 'youtube.com')){
            
            parse_str($parsedURL["query"], $param);
        
            switch (true) {
                case Str::contains($parsedURL['path'], '/playlist'):
                    $url    = "https://www.youtube.com/playlist?list=" . $param["list"];
                    break;

                case Str::contains($parsedURL['path'], '/watch'):
                    $url    = "https://youtube.com/watch?v=" . $param["v"];
                    break;
            }

        }else if(Str::contains($parsedURL['host'], 'youtu.be')){
            
            $param  = str_replace("/","",$parsedURL['path']);
            $url    = "https://youtube.com/watch?v=" . $param;

        }else{
            $url = strtok($url, '?');
        }

        return $url;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        if(!$link->exists())
            abort(404);

        return view('link.show', compact('link'));
    }

    public function search(Request $request)
    {
        $querySearch = $request->input('query');

        $links = Link::whereRaw('MATCH (title, body) AGAINST (?)' , array($querySearch))
                     ->where('draft', 0)->orderBy('id', 'desc')->get();

        return view('link.search', compact('links', 'querySearch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        if(!$link->exists())
            abort(404);

        checkOwnership($link->user_id);

        return view('link.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Link $link)
    {
        if(!$link->exists())
            abort(404);

        $request->validate([
            'url' => 'required',
            'title' => ['required', 'max:255', new MinimalWords(2)],
            'body' => ['required', new MinimalWords(5)],
            'tags' => 'required',
        ]);

        checkOwnership($link->user->id);

        $user = Auth::user();    
        
        $link->update([
            'title' => $request->title,
            'url'  => $this->cleanUrl($request->url),
            'body'  => $request->body,
            'tags'  => $request->tags,
            'media'  => $request->media,
            'owner'  => $request->owner,
            'draft' => ($request->draft == true) ? true : false,
            'original_published_at'  => $request->original_published_at ?? $link->original_published_at,
        ]);  

        //change session token
        $request->session()->regenerateToken();
        return redirect('/link/' . $link->slug)->with('success', 'Link berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        if(!$link->exists())
            abort(404);
        
        checkOwnership($link->user->id);

        $link->delete();
        return redirect('/')->with('success', 'Link berhasil dihapus');
    }
}
