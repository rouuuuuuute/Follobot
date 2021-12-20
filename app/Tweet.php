<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $fillable = ['tweet','reserved_at'];

    public function twitterAccount()
    {
        return $this->belongsTo('App\TwitterAccount');
    }
}
