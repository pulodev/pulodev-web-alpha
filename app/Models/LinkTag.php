<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkTag extends Model
{
    protected $fillable = ['tag_id','link_id'];
    public $timestamps = false;
    use HasFactory;
}
