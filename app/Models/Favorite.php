<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;

    public function getComments(Int $tweet_id)
    {
        return $this->with('user')->where('tweet_id', $tweet_id)->get();
    }
}
