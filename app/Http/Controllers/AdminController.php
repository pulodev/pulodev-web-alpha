<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Resource;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.index');
    }

    public function show($type)
    {
        if($type == 'rss')
            return $this->showRSS();
        else
            return $this->showLink();
    }

    public function showRSS()
    {
        $resources = Resource::where('draft', 1)->paginate(30);
        return view('dashboard.resource', compact('resources'));
    }

    public function showLink()
    {
        $links = Link::where('draft', 1)->paginate(30);
        return view('dashboard.links', compact('links'));
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

    public function verifyRSS($id)
    {
        Resource::find($id)->update(['draft' => 0]);

        return response([
            'msg' => 'rss published'
        ]);
    }
}
