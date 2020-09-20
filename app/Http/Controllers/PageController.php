<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Thread;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $links = Link::with('user')
                    ->orderBy('created_at', 'desc')->paginate(15);

        $threads = Thread::with('user')->withCount('comments')->where('draft', 0)
                        ->orderBy('last_activity_at', 'desc')->paginate(15);

        return view('welcome', compact('threads', 'links'));
    }
}
