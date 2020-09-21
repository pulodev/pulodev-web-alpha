<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $links = Link::with('user')->where('draft', 0)
                    ->orderBy('original_published_at', 'desc')->paginate(15);

        return view('welcome', compact('links'));
    }
}
