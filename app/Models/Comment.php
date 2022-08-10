<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * ホワイトリストのセット
     *
     * @var array
     */
    protected $fillable = [
        'text'
    ];

    /**
     * ユーザーのリレーションを定義
     * 
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * コメントをツイートのIDより取得
     * 
     * @return \Illuminate\Http\Response
     */
    public function getComments(int $tweetId)
    {
        return $this->with('user')->where('tweet_id', $tweetId)->get();
    }

    /**
     * コメント保存
     *
     * @param int $userId
     * @param array $data
     * 
     * @return void
     */
    public function commentStore(int $userId, array $data): void
    {
        $this->user_id = $userId;
        $this->tweet_id = $data['tweet_id'];
        $this->text = $data['text'];
        $this->save();
    }
}
