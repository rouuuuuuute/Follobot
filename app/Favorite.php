<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['favorite_keyword'];

    public function twitteraccount()
    {
        return $this->belongsTo('App\TwitterAccount');
    }
}
