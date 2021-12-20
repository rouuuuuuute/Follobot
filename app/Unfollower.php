<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unfollower extends Model
{
    protected $fillable = ['unfollow_name'];

    public function target()
    {
        return $this->belongsTo('App\Target');
    }
}
