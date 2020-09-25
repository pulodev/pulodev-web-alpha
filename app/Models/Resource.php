<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $dates = ['last_checked_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
