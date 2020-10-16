<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Resource;
use App\Rules\MinimalWords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends AbstractApiController
{
    /**
     * get resource (rss feed) with pagination
     * add limit to get n numbs of element
     * add page to get data from specific page
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $limit = $request->has('limit') && is_numeric($request->get('limit')) ? $request->get('limit') : self::MAX_PAGE_LIMIT;

        $resources = Resource::where('draft', 0)
                            ->whereRaw('DATE(last_checked_at) < DATE(NOW())')
                            ->orWhereNull('last_checked_at')->paginate($limit);

        $data = [];
        foreach($resources as $resource) {
            $latestLink = $resource->links()
                ->orderBy('original_published_at', 'desc')
                ->first();
             $data[] = [
                'id' => $resource->id,
                'name' => $resource->title,
                'url' => $resource->url,
                'type' => $resource->type,
                'media' => $resource->media,
                'user_id' => $resource->user_id,
                'last_update' => $resource->last_checked_at ? (new Carbon($resource->last_checked_at))->toDateTimeString() : NULL,
                'latest_published' => $latestLink !== NULL ? (new Carbon($latestLink->original_published_at))->toDateTimeString() : NULL
            ];
        }

        $pagination = ['limit' => $limit, 'current_page' => $resources->currentPage()];

        return $this->response($data, $pagination);
    }
}
