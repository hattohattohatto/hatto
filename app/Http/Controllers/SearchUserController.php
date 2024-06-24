<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Tweet;
use App\Models\User;

class SearchUserController extends Controller
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

        return view('searchUser', [
            'searchWord' => $searchWord,
        ]);
    }

    /**
     * ツイート検索結果表示
     *
     * @param Tweet $tweet
     * @param Request $request
     * 
     * @return \Illuminate\View\View
     */
    public function search(Tweet $tweet, Request $request)
    {
        $searchWord = $request->input('searchWord');

        $query = User::query();

        if (isset($searchWord)) {
            $query->where('screen_name', 'like', '%' . self::escapeLike($searchWord) . '%');
        }
        $users = $query->paginate(15);

        return view('searchUser', [
            'users' => $users,
            'tweet' => $tweet,
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
