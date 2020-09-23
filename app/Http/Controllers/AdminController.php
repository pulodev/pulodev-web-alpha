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

    public function deleteBulk(Request $request)
    {
        Link::destroy($request->items);

        return response([
            'msg' => 'delete completed'
        ]);
    }

    public function publishBulk(Request $request)
    {
        Link::whereIn('id', $request->items)->update(['draft' => 0]);

        return response([
            'msg' => 'items published'
        ]);
    }
}
