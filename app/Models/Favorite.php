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
     * ホワイトリストのセット
     * 
     * @var array
     */
    protected $fillable = [
        'user_id',
        'tweet_id'
    ];

    /**
     * コメントのIDを取得
     * 
     * @param  int $tweetId
     * 
     * @return \Illuminate\Http\Response
     */
    public function getComments(int $tweetId)
    {
        return $this->with('user')->where('tweet_id', $tweetId)->get();
    }

    /**
     * いいね判定
     *
     * @param int $userId
     * @param int $tweetId
     * 
     * @return boolean
     */
    public function isFavorite(int $userId, int $tweetId)
    {
        return (bool) $this->where('user_id', $userId)->where('tweet_id', $tweetId)->exists();
    }

    public function countFavorite(int $userId, int $tweetId)
    {
        return $this->where('user_id', $userId)->where('tweet_id', $tweetId)->count();
    }
}
