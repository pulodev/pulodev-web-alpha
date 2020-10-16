<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        switch($type) {
            case 'rss':
                return $this->showRSS();
                break;
            case 'link':
                return $this->showLink();
                break;
            case 'stats':
                return $this->showStats();
                break;    
            default:
                break;
        }
    }

    public function showRSS()
    {
        $resources = Resource::where('draft', 0)->paginate(30);
        $draftResources = Resource::where('draft', 1)->paginate(30);
        return view('dashboard.resource', compact('draftResources', 'resources'));
    }

    public function showLink()
    {
        $links = Link::where('draft', 1)->paginate(30);
        return view('dashboard.links', compact('links'));
    }

    public function showStats()
    {
        $linksCount = Link::count();
        $usersCount = User::count();
        $users = User::orderBy('created_at', 'desc')->paginate(30);

        return view('dashboard.stats', compact('linksCount', 'usersCount', 'users'));
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
