<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['favorite_keyword','favorite_keyword2','logic'];

    public function twitterAccount()
    {
        return $this->belongsTo('App\TwitterAccount');
    }
}
