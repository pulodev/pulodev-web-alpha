<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory, SoftDeletes, ElasticSearchIndexing;

    protected $guarded = ['id'];
    protected $dates = ['original_published_at'];
    private $esIndex = 'pb_link';

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function resource()
    {
        return $this->belongsTo('App\Models\Resource');
    }

    public function getESIndex()
    {
        return $this->esIndex;
    }

    public function getESBody()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'owner' => $this->owner,
            'media' => $this->media,
            'tags' => explode(',', $this->tags),
            'updated_at' => $this->updated_at,
            'original_published_at' => $this->original_published_at,
            'created_at' => $this->created_at,
            'user' => [
                'username' => $this->user->username,
                'fullname' => $this->user->fullname,
                'avatar_url' => $this->user->avatar_url,
            ]
        ];
    }
}
