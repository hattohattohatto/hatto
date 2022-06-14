<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoritesController extends Controller
{
    /**
     * いいね保存
     *
     * @param Request $request
     * @param Favorite $favorite
     * 
     * @return \Illuminate\Foundation\helpers
     */
    public function store(Request $request, Favorite $favorite)
    {
        $userId = auth()->id();
        $tweetId = $request->tweet_id;
        $isFavorite = $favorite->isFavorite($userId, $tweetId);

        if (!$isFavorite) {
            $favorite->fill([
                'user_id' => $userId,
                'tweet_id' => $tweetId,
            ]);
            $favorite->save();
        }
        return back();
    }

    /**
     * いいね削除
     *
     * @param Favorite $favorite
     * @param Request $request
     * 
     * @return \Illuminate\Foundation\helpers
     */
    public function destroy(Request $request, Favorite $favorite)
    {
        $userId = auth()->id();
        $tweetId = $request->tweet_id;
        $isFavorite = $favorite->isFavorite($userId, $tweetId);

        if ($isFavorite) {
            $favorite->where('user_id', $userId)->where('tweet_id', $tweetId)->delete();
        }
        return back();
    }
}
