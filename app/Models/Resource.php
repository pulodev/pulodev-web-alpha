<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $dates = ['last_checked_at','latest_publised_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function links()
    {
       return $this->hasMany('App\Models\Link');
    }

    public function getLatestPublishedAt()
    {
        $latest = $this->links()
            ->orderBy('original_published_at', 'desc')
            ->first();
        return $latest!==null ? $latest->original_published_at : null;
    }
}
