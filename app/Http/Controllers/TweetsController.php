<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
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
     * @param \App\Models\Tweet $tweet
     * @param \App\Models\Follower $follower
     * @param  \Illuminate\Http\Request  $request
     * 
     * 
     * @return \Illuminate\View\View
     */
    public function index(Tweet $tweet, Follower $follower, Request $request)
    {
        $user = auth()->user();
        $followingIds = $follower->followingIds($user->id)->pluck('followed_id')->toArray();
        $fetchTimelines = $tweet->getTimelines($user->id, $followingIds);
        $searchWord = $request->input('searchWord');

        return view('tweets.index', [
            'user'  => $user,
            'timelines' => $fetchTimelines,
            'searchWord' => $searchWord
        ]);
    }

    /**
     * ツイート作成
     * 
     * @param Request $request
     *
     * @return \Illuminate\view\View
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        $searchWord = $request->input('searchWord');

        return view('tweets.create', [
            'user' => $user,
            'searchWord' => $searchWord
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
     * @param Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function show(Tweet $tweet, Comment $comment, Request $request)
    {
        $user = auth()->user();
        $tweet = $tweet->getTweet($tweet->id);
        $comments = $comment->getComments($tweet->id);
        $searchWord = $request->input('searchWord');

        return view('tweets.show', [
            'user' => $user,
            'tweet' => $tweet,
            'comments' => $comments,
            'searchWord' => $searchWord,
        ]);
    }

    /**
     * ツイート編集
     *
     * @param Tweet $tweet
     * @param Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function edit(Tweet $tweet, Request $request)
    {
        $user = auth()->user();
        $tweets = $tweet->getEditTweet($user->id, $tweet->id);
        $searchWord = $request->input('searchWord');

        return isset($tweets) == False ? redirect('tweet') : view('tweets.edit', [
            'user' => $user,
            'tweets' => $tweets,
            'searchWord' => $searchWord
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
        if (!Gate::allows('update-tweet', $tweet)) {
            abort(403);
        }

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

        $retweetedId = Tweet::find($id)->user_id;
        $userName = User::find($retweetedId)->name;
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
