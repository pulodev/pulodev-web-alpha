<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = [
        'title',
        'url',
        'slug',	
        'body',
        'media',	
        'thumbnail',
        'tags',
        'owner',	
        'draft',	
        'user_id',
        'original_published_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'resource_id'
    ];
    protected $dates = ['original_published_at'];
    protected $tag_list;

    protected static function linktag($link)
    {
        foreach($link->tag_list as $tag){
            $tagModel = Tag::where('name',$tag)->firstOrCreate(['name'=>$tag]);
            $linkTag = new LinkTag();
            $linkTag->link_id = $link->id;
            $linkTag->tag_id = $tagModel->id;
            $linkTag->save();
        }
    }

    protected static function booted()
    {
        static::saved(function ($link) 
        {
            LinkTag::where('link_id',$link->id)->delete();
            static::linktag($link);
            
        });

        static::updated(function ($link) 
        {
            static::linktag($link);
        });
    }
    public function getTagsAttribute()
    {
        return implode(', ',$this->tags()->pluck('name')->all());
    }

    public function setTagsAttribute($value)
    {
        if(is_string($value)){
            $value = preg_split("/[\s,]+/", $value);
        }
        $this->tag_list = $value;
    }

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

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag','link_tags','link_id','tag_id');
    }
}
