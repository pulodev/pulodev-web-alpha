<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return $this->renderLinkView();
    }

    public function filterMedia($media)
    {
        return $this->renderLinkView('media', $media);
    }

    public function filterTag($tag)
    {
        return $this->renderLinkView('tag', $tag);
    }

    public function renderLinkView($type = '', $query = '')
    {
        $links = Link::with('user')->where('draft', 0);

        switch($type) {
            case 'media':
                $links = $links->where('media', $query);
                break;     
            case 'tag':
                $links = $links->where('tags', 'like' , '%'.$query.'%');
                break;         
            default: 
                break;
        }
        
        $links = $links->orderBy('original_published_at', 'desc')->paginate(15);
        return view('welcome', compact('links', 'type', 'query'));
    }
}
