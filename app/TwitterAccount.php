<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterAccount extends Model
{
    protected $fillable = ['screen_name','twitter_id','oauth_token','oauth_token_screen'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
