<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowedTarget extends Model
{
    protected $fillable = ['followed_name'];

    public function target()
    {
        return $this->belongsTo('App\Target');
    }
}
