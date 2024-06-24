<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Follower;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * ミドルウェアでのバリデーション
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('profile.validate')->only('update');
    }

    /**
     * ツイートのリストを表示
     * 
     * @param  User $User
     * 
     * @return \Illuminate\View\View
     */
    public function index(User $user, Request $request)
    {
        $users = $user->getAllUsers(auth()->id());
        $searchWord = $request->input('searchWord');

        return view('users.index', [
            'allUsers'  => $users,
            'searchWord' => $searchWord
        ]);
    }

    /**
     * ツイート表示
     *
     * @param  User $User
     * @param  Tweet $Tweet
     * @param  Follower $Follower
     * @param Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function show(User $user, Tweet $tweet, Follower $follower, Request $request)
    {
        $isFollowing = auth()->user()->isFollowing($user->id);
        $isFollowed = auth()->user()->isFollowed($user->id);
        $timelines = $tweet->getUserTimeLine($user->id);
        $tweetCount = $tweet->getTweetCount($user->id);
        $followCount = $follower->getFollowCount($user->id);
        $followerCount = $follower->getFollowerCount($user->id);
        $searchWord = $request->input('searchWord');

        return view('users.show', [
            'user' => $user,
            'isFollowing' => $isFollowing,
            'isFollowed' => $isFollowed,
            'timelines' => $timelines,
            'tweetCount' => $tweetCount,
            'followCount' => $followCount,
            'followerCount' => $followerCount,
            'searchWord' => $searchWord
        ]);
    }

    /**
     * ツイート作成
     *
     * @param  User $user
     * @param Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function edit(User $user, Request $request)
    {
        $searchWord = $request->input('searchWord');

        return view('users.edit', [
            'user' => $user,
            'searchWord' => $searchWord
        ]);
    }

    /**
     * ツイート編集
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $tweetData = $request->all();
        $user->updateProfile($tweetData);

        return redirect('users/' . $user->id);
    }

    /**
     * フォロー
     *
     * @param Follower $follower
     * @param Request $request
     * 
     * @return \Illuminate\Foundation\helpers
     */
    public function follow(Follower $follower, Request $request)
    {
        $followedId = $request->follow_review_id;
        $followingId = auth()->id();
        $isFollowing = auth()->user()->isFollowing($followedId);
        if (!$isFollowing) {
            $follower->fill([
                'following_id' => $followingId,
                'followed_id' => $followedId,
            ]);
            $follower->save();
        } else {
            $follower->where('following_id', $followingId)->where('followed_id', $followedId)->delete();
        }

        $param = [
            'followerCount' => $follower->getFollowerCount($followedId),
        ];
        return response()->json($param);
    }
}
