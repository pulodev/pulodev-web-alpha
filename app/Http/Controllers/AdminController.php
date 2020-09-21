<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $links = Link::where('draft', 1)->paginate(30);
        return view('dashboard.index', compact('links'));
    }
}
