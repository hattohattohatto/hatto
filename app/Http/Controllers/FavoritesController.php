<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoritesController extends Controller
{
    /**
     * いいね処理
     *
     * @param Request $request
     * @param Favorite $favorite
     * 
     * @return \Illuminate\Foundation\helpers
     */
    public function favorite(Request $request, Favorite $favorite)
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
        } else {
            $favorite->where('user_id', $userId)->where('tweet_id', $tweetId)->delete();
        }

        $param = ['favoriteCount' => $favorite->countFavorite($tweetId)];
        return response()->json($param);
    }
}
