<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = ['target_name'];

    public function twitterAccount()
    {
        return $this->belongsTo('App\TwitterAccount');
    }

    public function followingTargets()
    {
        return $this->hasMany('App\FollowingTarget');
    }

    public function followedTargets()
    {
        return $this->hasMany('App\FollowedTarget');
    }

    public function unfollowers()
    {
        return $this->hasMany('App\Unfollower');
    }

}
