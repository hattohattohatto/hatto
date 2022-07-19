<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Tweet;
use App\Models\User;

class SearchController extends Controller
{
    /**
     * ツイート検索欄
     *
     * @param Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $searchWord = $request->input('searchWord');

        return view('searchTweet', [
            'searchWord' => $searchWord,
        ]);
    }

    /**
     * ツイート検索結果表示
     *
     * @param User $user
     * @param Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function search(User $user, Request $request)
    {
        $searchWord = $request->input('searchWord');

        $query = Tweet::query();

        if (isset($searchWord)) {
            $query->where('text', 'like', '%' . self::escapeLike($searchWord) . '%');
        }
        $tweets = $query->paginate(15);

        return view('searchTweet', [
            'user' => $user,
            'tweets' => $tweets,
            'searchWord' => $searchWord,
        ]);
    }

    /**
     * ツイート検索においての記号等の排除
     *
     * @param [type] $str
     * 
     * @return \Illuminate\Http\Response
     */
    public static function escapeLike($str)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
    }
}
