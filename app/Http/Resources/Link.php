<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Resource as ResourceResource;
use App\Models\User;
use App\Models\Resource;

class Link extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'orginal_published_at' => $this->original_published_at,
            'published_diff' => $this->original_published_at->diffForHumans(),
            'tags'=> $this->tags,
            'media' => $this->media,
            'resource' => new ResourceResource(Resource::find($this->resource_id)),
            'thumbnail' => $this->thumbnail,
            'owner' => $this->owner,
            'user' => new UserResource(User::find($this->user_id)),
            'body' => $this->body
        ];
    }
}
