<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Rules\MinimalWords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('link.create');
    }

    public function scrape(Request $request)
    {
        //check if include https. 
        //avoid broken link
        
        $response = Http::get($request->url);
        $htmlContent = $response->body();
        
        //Title Tag
        preg_match('/<title(.*?)>(.*?)<\/title>/s', $htmlContent, $matchTitle);
        //Meta Tag
        $tags = get_meta_tags($request->url);

        return response()->json([
            'title' => end($matchTitle),
            'description' => $tags['description'],
            'author' => $tags['author'] ?? '',
        ]);
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


        //logika tag. two words jadi satu dengan - . 
        $user = Auth::user();    
        
        $link = $user->links()->create([
            'title' => $request->title,
            'url'  => $request->url,
            'slug'  => generateSlug($request->title, new Link),
            'body'  => $request->body,
            'tags'  => $request->tags,
            'twitter_owner'  => $request->twitter_owner,
        ]);  

        //change session token
        $request->session()->regenerateToken();
        return redirect('/link/' . $link->slug)->with('success', 'Link berhasil disubmit');
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
        $links = Link::with('user')->where('title', 'like', '%'.$querySearch.'%')
                    ->orderBy('id', 'desc')->get();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        //
    }
}
