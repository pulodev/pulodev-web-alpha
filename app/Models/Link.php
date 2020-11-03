<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $dates = ['original_published_at'];

    protected static function booted()
    {
        static::saved(function ($link) {
            App\Models\LinkTag::where('link_id',$link->id)->delete();

            foreach($link->tags_list as $tag){
                $tagModel = App\Models\Tag::where('name',$tag)->firstOrCreate(['name'=>$tag]);

                $linkTag = new App\Models\LinkTag();
                $linkTag->link_id = $link->id;
                $linkTag->tag_id = $tagModel->id;
                $linkTag->save();
            }
        });
    }

    public function setTagsAttribute($value)
    {
        if(is_string($value)){
            $value = preg_split("/[\s,]+/", $value);
        }

        $this->attributes['tag_list'] = $value;
        
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
        return $this->belongsToMany('App\Models\Tag');
    }
}
