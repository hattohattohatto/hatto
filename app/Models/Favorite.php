<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /**
     * タイムスタンプ更新の無効化
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * ツイートのIDを取得
     * 
     * @param  int $tweetId
     * 
     * @return \Illuminate\Http\Response
     */
    public function getComments(int $tweetId)
    {
        return $this->with('user')->where('tweet_id', $tweetId)->get();
    }
}
