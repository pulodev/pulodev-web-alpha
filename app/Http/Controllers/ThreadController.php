<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Thread;
use App\Rules\MinimalWords;
use Illuminate\Http\Request;

class ThreadController extends Controller
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
        return view('thread.create');
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
            'title' => ['required', 'max:255', new MinimalWords(2)],
            'body' => ['required', new MinimalWords(10)],
            'tags' => 'required',
        ]);


        //logika tag. two words jadi satu dengan - . 
        $user = Auth::user();    
        
        $thread = $user->threads()->create([
            'title'   => $request->title,
            'slug'    => generateSlug($request->title, new Thread),
            'body' => $request->body,
            'tags' => $request->tags,
            'draft' => ($request->draft == true) ? true : false,
            'last_activity_at' => Carbon::now()
        ]);  

        //change session token
        $request->session()->regenerateToken();
        return redirect('/' . $thread->slug)->with('success', 'pertanyaan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        if(!$thread->exists())
            abort(404);

        $thread->load('comments', 'comments.user');

        return view('thread.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        if(!$thread->exists())
            abort(404);

        checkOwnership($thread->user->id);

        return view('thread.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        if(!$thread->exists())
            abort(404);
        
        $request->validate([
            'title' => ['required', 'max:255', new MinimalWords(2)],
            'body' => ['required', new MinimalWords(10)],
            'tags' => 'required',
        ]);


        checkOwnership($thread->user->id);
        
        $thread->update([
            'title'   => $request->title,
            'body' => $request->body,
            'tags' => $request->tags,
            'draft' => ($request->draft == true) ? true : false,
            'last_activity_at' => Carbon::now()
        ]);  

        //change session token
        $request->session()->regenerateToken();
        return redirect('/' . $thread->slug)->with('success', 'pertanyaan berhasil doupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
