<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Thread;
use App\Models\Comment;
use App\Rules\MinimalWords;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $thread_id)
    {
        $request->validate([
            'body' => ['required', new MinimalWords(3)],
        ]);

        $user = Auth::user();    
        $thread = Thread::findOrFail($thread_id);
        
        $user->comments()->create([
            'body' => $request->body,
            'thread_id' => $thread->id
        ]);  

        //change session token
        $request->session()->regenerateToken();
        return redirect('/' . $thread->slug)->with('success', 'komentar berhasil dibuat');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        checkOwnership($comment->user_id);

        return view('thread.edit-comment', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'body' => ['required', new MinimalWords(3)],
        ]);

        $comment = Comment::findOrFail($id);
        checkOwnership($comment->user_id);

        $comment->update(['body' => $request->body]);
        $threadSlug = $comment->thread->slug;
        
        return redirect('/' . $threadSlug)->with('success', 'komentar berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        checkOwnership($comment->user_id);
        $comment->delete();
        $threadSlug = $comment->thread->slug;
        
        return redirect('/' . $threadSlug)->with('success', 'komentar berhasil diupdate');
    }
}
