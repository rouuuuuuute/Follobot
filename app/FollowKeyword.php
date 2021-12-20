<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowKeyword extends Model
{
    protected $fillable = ['keyword','keyword2','logic'];

    public function twitterAccount()
    {
        return $this->belongsTo('App\TwitterAccount');
    }

}
