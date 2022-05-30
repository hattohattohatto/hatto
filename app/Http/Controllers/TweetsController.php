<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\Comment;
use App\Models\Follower;
use Illuminate\Support\Facades\Auth;

class TweetsController extends Controller
{
    /**
     * ミドルウェアでのバリデーション
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('tweet')->only(['store', 'update']);
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
        $followIds = $follower->followingIds($user->id);
        $followingIds = $followIds->pluck('followed_id')->toArray();

        $timelines = $tweet->getTimelines($user->id, $followingIds);

        return view('tweets.index', [
            'user'      => $user,
            'timelines' => $timelines
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
     * @param  Illuminate\Support\Facades\Auth
     *       
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Tweet $tweet)
    {
        $id = Auth::id();
        $data = $request->all();
        $tweet->tweetStore($id, $data);

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
            'user'     => $user,
            'tweet'    => $tweet,
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

        if (!isset($tweets)) {
            return redirect('tweets');
        }

        return view('tweets.edit', [
            'user'   => $user,
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
        $data = $request->all();
        $tweet->tweetUpdate($tweet->id, $data);

        return redirect('tweets');
    }

    /**
     * ツイート削除
     *
     * @param  \App\Models\Tweet $tweet
     * @param  \lluminate\Support\Facades\Auth
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tweet $tweet)
    {
        $userId = Auth::id();
        $tweet->tweetDestroy($userId, $tweet->id);

        return back();
    }
}
