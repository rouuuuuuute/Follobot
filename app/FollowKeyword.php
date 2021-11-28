<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowKeyword extends Model
{
    protected $fillable = ['keyword'];

    public function twitteraccount()
    {
        return $this->belongsTo('App\TwitterAccount');
    }

}
