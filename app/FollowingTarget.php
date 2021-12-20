<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowingTarget extends Model
{
    protected $fillable = ['following_name'];

    public function target()
    {
        return $this->belongsTo('App\Target');
    }
}
