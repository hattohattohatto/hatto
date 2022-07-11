<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\Comment;
use App\Models\Follower;
use App\Models\User;
use phpDocumentor\Reflection\PseudoTypes\False_;

class TweetsController extends Controller
{
    /**
     * ミドルウェアでのバリデーション
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('tweet.validate')->only(['store', 'update']);
    }

    /**
     * ツイートのリストを表示
     *
     * @param \App\Models\Tweet
     * @param \App\Models\Follower
     * 
     * @return \Illuminate\View\View
     */
    public function index(Tweet $tweet, Follower $follower)
    {
        $user = auth()->user();
        $followingIds = $follower->followingIds($user->id)->pluck('followed_id')->toArray();
        $fetchTimelines = $tweet->getTimelines($user->id, $followingIds);

        return view('tweets.index', [
            'user'  => $user,
            'timelines' => $fetchTimelines
        ]);
    }

    /**
     * ツイート作成
     *
     * @return \Illuminate\view\View
     */
    public function create()
    {
        $user = auth()->user();

        return view('tweets.create', [
            'user' => $user
        ]);
    }

    /**
     * ツイート保存機能
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tweet $tweet
     *       
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Tweet $tweet)
    {
        $userId = auth()->id();
        $tweetData = $request->all();
        $tweet->tweetStore($userId, $tweetData);

        return redirect('tweets');
    }

    /**
     * ツイート表示
     *
     * @param  \App\Models\Tweet $tweet
     * @param  \App\Models\Comment $comment
     * 
     * @return \Illuminate\View\View
     */
    public function show(Tweet $tweet, Comment $comment)
    {
        $user = auth()->user();
        $tweet = $tweet->getTweet($tweet->id);
        $comments = $comment->getComments($tweet->id);

        return view('tweets.show', [
            'user' => $user,
            'tweet' => $tweet,
            'comments' => $comments
        ]);
    }

    /**
     * ツイート編集
     *
     * @param Tweet $tweet
     * 
     * @return \Illuminate\View\View
     */
    public function edit(Tweet $tweet)
    {
        $user = auth()->user();
        $tweets = $tweet->getEditTweet($user->id, $tweet->id);

        return isset($tweets) == False ? redirect('tweet') : view('tweets.edit', [
            'user' => $user,
            'tweets' => $tweets
        ]);
    }

    /**
     * ツイート更新
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tweet $tweet
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tweet $tweet)
    {
        $tweetData = $request->all();
        $tweet->tweetUpdate($tweet->id, $tweetData);

        return redirect('tweets');
    }

    /**
     * ツイート削除
     *
     * @param  \App\Models\Tweet $tweet
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tweet $tweet)
    {
        $userId = auth()->id();
        $tweet->tweetDestroy($userId, $tweet->id);

        return back();
    }

    /**
     * リツイート機能
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tweet $tweet
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function retweet(int $id, User $user, Tweet $tweet)
    {
        $userId = auth()->id();

        $retweetedName = Tweet::find($id)->user_id;
        $userName = User::find($retweetedName)->name;
        $retweetText = Tweet::find($id)->text;

        $retweet = ">RT from " . $userName . "\n" . $retweetText;

        $tweet->fill([
            'user_id' => $userId,
            'text' => $retweet
        ]);
        $tweet->save();
        return back();
    }
}
