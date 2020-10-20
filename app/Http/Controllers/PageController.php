<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Resources\LinkCollection;

class PageController extends Controller
{
    public function index(Request $request)
    {
        return $this->renderLinkView($request); 
    }

    public function filterMedia(Request $request, $media)
    {
        return $this->renderLinkView($request, 'media', $media);
    }

    public function filterTag(Request $request, $tag)
    {
        return $this->renderLinkView($request, 'tag', $tag);
    }

    public function filterTime(Request $request, $query)
    {
        return $this->renderLinkView($request, 'order', $query);
    }

    public function renderLinkView($request, $type = '', $query = '')
    {
        $links = Link::with('user')->where('draft', 0);

        switch($type) {
            case 'media':
                $links = $links->where('media', $query);
                break;     
            case 'tag':
                $links = $links->where('tags', 'like' , '%'.str_replace('-', ' ', $query).'%')
                               ->orWhere('tags', 'like' , '%'.$query.'%');
                break;     
            case 'order':
                $links = $links->orderBy('original_published_at', 'desc');
                break;             
            default: 
                break;
        }
        
        $links = $links->orderBy('created_at', 'desc')->paginate(15);
        if($request->type==='json')
            return new LinkCollection($links);
        else
            return view('welcome', compact('links', 'type', 'query'));
    }

    public function info($page)
    {
        return view('pages.' . $page);
    }
}
