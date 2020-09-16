<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
